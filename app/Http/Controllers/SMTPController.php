<?php

namespace App\Http\Controllers;

use App\Models\SmtpModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SMTPController extends Controller
{
    // SMTP
    public function index()
    {
        $page_title = 'Email Configuration';

        $smtp = SmtpModel::first();

        return view('settings.smtp', compact('page_title', 'smtp'));
    }

    public function smtpupdate(Request $request)
    {
        $smtpId = $request->smtp_id;

        $data = $request->only([
            'mailer',
            'host',
            'port',
            'username',
            'password',
            'encryption',
            'from_address',
            'from_name',
            'status',
        ]);

        $data['updated_by'] = current_user_id() ?? null;

        if ($smtpId) {
            SmtpModel::where('smtp_id', $smtpId)->update($data);
            $message = 'SMTP settings updated successfully';
        } else {
            SmtpModel::create($data);
            $message = 'SMTP settings saved successfully';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }

public function testSmtpMail()
{
    $smtp = set_smtp_config();

    if (! $smtp) {
        return response()->json([
            'status' => false,
            'message' => 'No active SMTP configuration found'
        ]);
    }

    Mail::raw(
        'This is a test email from SMTP configuration.',
        function ($message) use ($smtp) {
            $message->to($smtp->username)
                    ->subject('SMTP Test Email');
        }
    );

    return response()->json([
        'status' => true,
        'message' => 'Test email sent successfully'
    ]);
}
}
