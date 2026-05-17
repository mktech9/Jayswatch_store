<?php

use App\Models\SmtpModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

if (! function_exists('set_smtp_config')) {

    function set_smtp_config()
    {
        $smtp = SmtpModel::where('status', 0)->first();

        if (! $smtp) {
            return false;
        }

        config([
            'mail.default' => $smtp->mailer ?? 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => $smtp->host,
            'mail.mailers.smtp.port' => $smtp->port,
            'mail.mailers.smtp.username' => $smtp->username,
            'mail.mailers.smtp.password' => $smtp->password,
            'mail.mailers.smtp.encryption' => $smtp->encryption,
            'mail.from.address' => $smtp->from_address,
            'mail.from.name' => $smtp->from_name,
        ]);

        return $smtp;
    }
}

// if (!function_exists('send_multi_recipient_mail')) {
//     function send_multi_recipient_mail($subject, $body, $replyTo = null, $cc = [])
//     {
//         $emails = DB::table('tbl_emails')
//             ->where('status', 0)
//             ->pluck('email')
//             ->filter()
//             ->toArray();

//         if (empty($emails)) {
//             return false;
//         }

//         Mail::raw($body, function ($mail) use ($emails, $subject, $replyTo, $cc) {
//             $mail->to($emails)->subject($subject);

//             if (!empty($cc)) {
//                 $mail->cc($cc);
//             }

//             if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
//                 $mail->replyTo($replyTo);
//             }
//         });

//         return true;
//     }
// }


// if (!function_exists('send_multi_recipient_mail')) {
//     function send_multi_recipient_mail($subject, $body, $replyTo = null, $cc = [])
//     {
//         $emails = DB::table('tbl_emails')
//             ->where('status', 0)
//             ->pluck('email')
//             ->filter()
//             ->toArray();

//         if (empty($emails)) {
//             return false;
//         }

//         Mail::send([], [], function ($mail) use ($emails, $subject, $body, $replyTo, $cc) {
//             $mail->to($emails)
//                 ->subject($subject)
//                 ->html($body); // ✅ Important fix

//             if (!empty($cc)) {
//                 $mail->cc($cc);
//             }

//             if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
//                 $mail->replyTo($replyTo);
//             }
//         });

//         return true;
//     }
// }

if (!function_exists('send_multi_recipient_mail')) {

    function send_multi_recipient_mail($subject, $body, $replyTo = null, $cc = [], $extraEmails = [])
    {
        $emails = DB::table('tbl_emails')
            ->where('status', 0)
            ->pluck('email')
            ->filter()
            ->toArray();

        // Merge extra emails
        if (!empty($extraEmails)) {
            $emails = array_merge($emails, (array) $extraEmails);
        }

        // Remove duplicate emails
        $emails = array_unique(array_filter($emails));

        if (empty($emails)) {
            return false;
        }

        Mail::send([], [], function ($mail) use ($emails, $subject, $body, $replyTo, $cc) {

            $mail->to($emails)
                ->subject($subject)
                ->html($body);

            if (!empty($cc)) {
                $mail->cc($cc);
            }

            if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
                $mail->replyTo($replyTo);
            }
        });

        return true;
    }
}
