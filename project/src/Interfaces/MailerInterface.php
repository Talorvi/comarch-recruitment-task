<?php

namespace App\Interfaces;

interface MailerInterface
{
    public function sendMail(string $to, string $subject, string $message, string $headers): bool;
}