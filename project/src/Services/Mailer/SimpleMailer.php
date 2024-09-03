<?php

namespace App\Services\Mailer;

use App\Interfaces\MailerInterface;

class SimpleMailer implements MailerInterface
{
    public function sendMail(string $to, string $subject, string $message, string $headers): bool
    {
        return mail($to, $subject, $message, $headers);
    }
}