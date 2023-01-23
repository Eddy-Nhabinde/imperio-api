<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    function sendPassword($email, $cod)
    {
        $email_data = [
            'recipient' => $email,
            'from' => 'dlabteamsd@gmail.com',
            'fromname' => 'Imperio',
            'subject' => 'Reposicao da senha',
            'cod' => $cod,
            // 'nome' => $nome,
            // 'apelido' => $apelido,
        ];


        if ($this->sendEmail($email_data) == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    function sendEmail($email_data)
    {
        try {
            Mail::send('new_request', $email_data, function ($message) use ($email_data) {
                $message->to($email_data['recipient'])
                    ->from($email_data['from'], $email_data['fromname'])
                    ->subject($email_data['subject']);
            });
            return 1;
        } catch (Exception $e) {
            dd($e);
        }
    }
}
