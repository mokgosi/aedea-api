<?php

namespace App\Service;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerService
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function sendEmail(Contact $contact): void
    {
        //TODO: 
        $contact = (new TemplatedEmail())
            ->from(new Address('no-reply@example.com', 'Website Contact Form'))
            ->to('admin@example.com', $contact->getEmail())
            ->replyTo($contact->getName() . ' <' . $contact->getEmail() . '>')
            ->subject('New Contact Form Submission: ' . $contact->getSubject())
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'name' => $contact->getName(),
                'message' => $contact->getMessage(),
            ]);

        $this->mailer->send($contact);
    }
}