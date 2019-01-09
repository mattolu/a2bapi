<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class RegisterConfirmation extends Mailable
{
    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // { 
    //     $password = app('request')->get('password');
    //     $email=  app('request')->get('email');
    //     $lastname=  app('request')->get('lastname');
    //     return $this->view('RegisterConfirmationEmail', ['email'=> $email,'password' => $password, 'lastname' => $lastname]);
    // }
}