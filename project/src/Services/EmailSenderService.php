<?php

namespace App\Services;

use App\Interfaces\FileSystemInterface;
use App\Interfaces\MailerInterface;

class EmailSenderService
{
    private MailerInterface $mailer;
    private FileSystemInterface $fileSystem;

    public function __construct(MailerInterface $mailer, FileSystemInterface $fileSystem)
    {
        $this->mailer = $mailer;
        $this->fileSystem = $fileSystem;
    }

    public function send($user, $messageTemplate): void
    {
        $personalizedMessage = str_replace(
            ["{first_name}", "{last_name}"],
            [$user->firstName, $user->lastName],
            $messageTemplate
        );

        $to = $user->email;
        $subject = "Subject";
        $headers = "From: test@example.com";

        if ($this->fileSystem->isDirectory(__DIR__ . '/../../logs') || $this->fileSystem->createDirectory(__DIR__ . '/../../logs', 0755, true)) {
            $logFile = __DIR__ . '/../../logs/email_log.txt';
            $logMessage = "To: $to\nSubject: $subject\nHeaders: $headers\nMessage:\n$personalizedMessage\n-------------------------------------\n";
            $this->fileSystem->appendToFile($logFile, $logMessage);
        }

        // Uncomment to send the emails
        // $this->mailer->sendMail($to, $subject, $personalizedMessage, $headers);
    }
}
