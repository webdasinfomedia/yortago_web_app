<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Mail;

trait NotificationTrait
{

    public function new_user_registered_mail_to_admin($user)
    {
        Mail::send([], [], function ($message) use ($user) {
            $message->to('info@yortago.com')
                ->subject('New user registered')
                ->setBody('<h1>Hi,</h1><p>A new user <b>(' . $user->name . ')</b> registered. Goto dashboard for more details</p>', 'text/html');
        });
    }
}