<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->username;
        $password = md5($request->password);
        $rememberMe = $request->has('remember_me'); // ✅

        $superAdmin = DB::table('super_admin')
            ->where('sp_username', $username)
            ->where('sp_password', $password)
            ->first();

        if ($superAdmin) {

            Session::put('login_type', 'super_admin');
            Session::put('super_admin_id', $superAdmin->sp_id);
            Session::put('super_admin_username', $superAdmin->sp_username);

            if ($rememberMe) {
                Cookie::queue('remember_login', json_encode([
                    'type' => 'super_admin',
                    'id' => $superAdmin->sp_id,
                ]), 60 * 24 * 7);
            }

            return response()->json([
                'status' => true,
                'redirect' => route('dashboard'),
            ]);
        }

        $staff = DB::table('tbl_staff')
            ->where('user_name', $username)
            ->where('password', $password)
            ->where('status', 0)
            ->first();

        if ($staff) {

            // 🔒 Blocked conditions
            if ($staff->login_status == 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Login Blocked Please Contact Administration',
                ], 403);
            }

            if ($staff->status == 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your account is not available',
                ], 403);
            }

            if ($staff->active_status == 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your account is not active',
                ], 403);
            }

            // ✅ Normal login flow
            DB::table('tbl_staff')
                ->where('staff_id', $staff->staff_id);
            // ->update(['active_status' => 1]);

            Session::put('login_type', 'staff');
            Session::put('role_id', $staff->role_id);
            Session::put('staff_id', $staff->staff_id);
            Session::put('staff_username', $staff->user_name);
            Session::put('staff_first_name', $staff->first_name);
            Session::put('staff_last_name', $staff->last_name);

            activity_log(
                menuType: 'user',
                logType: 'login_activity',
                description: 'Staff logged in successfully',
                userId: $staff->staff_id,
                status: 0
            );

            if ($rememberMe) {
                Cookie::queue('remember_login', json_encode([
                    'type' => 'staff',
                    'id' => $staff->staff_id,
                ]), 60 * 24 * 7);
            }

            return response()->json([
                'status' => true,
                'redirect' => route('dashboard'),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid username or password',
        ], 401);
    }

    public function logout()
    {
        if (session('login_type') === 'staff') {

            activity_log(
                menuType: 'user',
                logType: 'logout_activity',
                description: 'Staff logged out successfully',
                userId: session('staff_id'),
                status: 0
            );

        }

        Session::flush();
        Cookie::queue(Cookie::forget('remember_login'));

        return redirect()->route('login');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        // 🔍 Check Super Admin
        $superAdmin = DB::table('super_admin')
            ->where('sp_email', $email)
            ->first();

        // 🔍 Check Staff
        $staff = DB::table('tbl_staff')
            ->where('email_id', $email)
            ->where('status', 0)
            ->where('active_status', 0)
            ->where('login_status', 0)
            ->first();

        if (! $superAdmin && ! $staff) {
            return response()->json([
                'status' => false,
                'message' => 'Email not registered',
            ], 404);
        }

        $userType = $superAdmin ? 'super_admin' : 'staff';

        // 🔑 Generate token
        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $token,
                'user_type' => $userType,
                'created_at' => now(),
            ]
        );

        $resetLink = route('password.reset', $token);

        // 🔧 APPLY SMTP CONFIG FROM HELPER
        $smtp = set_smtp_config();

        if (! $smtp) {
            return response()->json([
                'status' => false,
                'message' => 'Mail service not configured. Contact admin.',
            ], 500);
        }

        // ✉️ Send Email
        Mail::send('reset_password', [
            'link' => $resetLink,
            'type' => $userType,
        ], function ($message) use ($email) {
            $message->to($email)
                ->subject('Reset Your Password');
        });

        return response()->json([
            'status' => true,
            'message' => 'Password reset link sent to your email',
        ]);
    }

    public function showResetForm($token)
    {
        $reset = DB::table('password_resets')
            ->where('token', $token)
            ->first();

        if (! $reset) {
            return redirect()->route('login')->with([
                'toast_type' => 'info',
                'toast_message' => 'Reset link expired. Please request again.',
            ]);
        }
        // ⏰ Check expiry (1 minute)
        if (now()->diffInSeconds($reset->created_at) > 60) {
            DB::table('password_resets')->where('token', $token)->delete();

            return redirect()->route('login')->with([
                'toast_type' => 'info',
                'toast_message' => 'Reset link expired. Please request again.',
            ]);
        }

        return view('forgot_pass', [
            'token' => $token,

            'email' => $reset->email,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $reset = DB::table('password_resets')
            ->where('token', $request->token)
            ->first();

        if (! $reset) {
            return back()->withErrors([
                'token' => 'Invalid reset token',
            ]);
        }

        // ⏰ Expiry check (1 minute)
        if (now()->diffInSeconds($reset->created_at) > 60) {
            DB::table('password_resets')
                ->where('token', $request->token)
                ->delete();

            return back()->withErrors([
                'token' => 'Reset link expired',
            ]);
        }

        // 🔐 Update password based on user_type
        if ($reset->user_type === 'super_admin') {
            DB::table('super_admin')
                ->where('sp_email', $reset->email)
                ->update([
                    'sp_password' => md5($request->password),
                ]);
        } else {
            DB::table('tbl_staff')
                ->where('email_id', $reset->email)
                ->update([
                    'password' => md5($request->password),
                ]);
        }

        DB::table('password_resets')
            ->where('email', $reset->email)
            ->delete();

        return redirect()
            ->route('login')
            ->with('success', 'Password updated successfully');
    }
}


