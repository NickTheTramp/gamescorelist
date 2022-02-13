<?php

namespace App\MessageHandler;

use App\Message\EmailMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Address;

class EmailMessageHandler implements MessageHandlerInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(EmailMessage $emailMessage)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('noreply@scorecard.nickthetramp.nl', 'ScoreCard'))
            ->to($emailMessage->getEmail())
            ->subject('🕹 ScoreCard • Password Reset')
            ->htmlTemplate('email/password-reset.html.twig');

        $this->mailer->send($email);
    }
}
