        <?php

use Illuminate\Support\Facades\Mail;

function sendEmail($to, $subject, $view, $data)
{
    try {
        Mail::send($view, $data, function ($message) use ($data, $subject, $to) {
            $emailFrom = env('MAIL_FROM_ADDRESS');
            $emailName = env('MAIL_FROM_NAME');
        
            \Log::info($to);
            \Log::info($emailFrom . '  ' . $emailName);
        
            $message->to($to);
            $message->from($emailFrom, $emailName);
            $message->subject($subject);
        });
        
    } //catch exception
    catch (\Exception $e) {
        echo $e->getMessage();
    }
}