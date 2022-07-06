<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response, DB, Config;
use App\Mail\MailNotify;
use App\Mail\MyDemoMail;
use App\Mail\MyTestMail;

use Exception;
use Mail;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $user = auth()->user();
        $user = 'developer197855@gmail.com';
        try {
            Mail::to($user)->send(new MyTestMail($user));
        } catch (Exception $ex) {
            dd($ex);
            return $this->markdown('emails.contact.contact-form')->from('example@test.in', 'Example');
        }
    }
}
