<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
Use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct (private MailerInterface $mailer) {

    }

    public function sendEmail(
        $to = 'edivieito@gmail.com',
        $subject = '',
        $content = '',
        $text = ''
    ): void{
        $email = (new Email())
            ->from('noreply@mysite.com')
            ->to('info@patronate.eu')
            ->subject($subject)
            ->text($text)
            ->html($content);
        $this->mailer->send($email);
    }
}