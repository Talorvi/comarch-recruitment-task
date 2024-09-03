<?php

namespace Service;

use App\Interfaces\FileSystemInterface;
use App\Interfaces\MailerInterface;
use App\Services\EmailSenderService;
use PHPUnit\Framework\TestCase;

class EmailSenderServiceTest extends TestCase
{
    public function testSend()
    {
        $mailerMock = $this->createMock(MailerInterface::class);
        $fileSystemMock = $this->createMock(FileSystemInterface::class);

        $user = (object)['firstName' => 'John', 'lastName' => 'Doe', 'email' => 'john@example.com'];
        $messageTemplate = "Hello {first_name} {last_name}";

        // Uncomment when send_mail is active in EmailSenderService
//        $mailerMock->expects($this->once())
//            ->method('sendMail')
//            ->with(
//                $this->equalTo('john@example.com'),
//                $this->equalTo('Subject'),
//                $this->equalTo('Hello John Doe'),
//                $this->equalTo('From: test@example.com')
//            )
//            ->willReturn(true);

        $fileSystemMock->expects($this->once())
            ->method('isDirectory')
            ->willReturn(true);

        $fileSystemMock->expects($this->once())
            ->method('appendToFile')
            ->willReturn(true);

        $service = new EmailSenderService($mailerMock, $fileSystemMock);
        $service->send($user, $messageTemplate);
    }
}
