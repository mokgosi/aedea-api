<?php

namespace App\EventListener;

use App\Entity\Contact;
use App\Service\MailerService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(
    event: Events::postPersist,
    method: 'postPersist',
    entity: Contact::class
)]
class ContactCreatedListener
{
    public function __construct( private readonly MailerService $mailerService ) 
    {
    }

    public function postPersist(Contact $contact ): void 
    {
        $this->mailerService->sendEmail($contact);
    }
}