<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Symfony\Component\Validator\Constraints as Assert;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use App\State\ContactProcessor;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ApiResource(
    description: 'Describes a contact form submission.',
    processor: ContactProcessor::class
)]
#[ApiFilter(
    OrderFilter::class,
    properties: [
        'createdAt' => 'DESC',
        'name',
        'email',
    ]
)]
#[ApiResource(
    paginationEnabled: true,
    paginationItemsPerPage: 5
)]
#[HasLifecycleCallbacks]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(
        message: 'Name is required.'
    )]
    #[Assert\Length(
        min: 2,
        minMessage: 'Name must be at least {{ limit }} characters.'
    )]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\NotBlank(
        message: 'Email is required.'
    )]
    #[Assert\Email(
        message: 'Please enter a valid email address.'
    )]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Assert\NotBlank(
        message: 'Subject is required.'
    )]
    #[Assert\Length(
        min: 3,
        minMessage: 'Subject must be at least {{ limit }} characters.'
    )]
    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[Assert\NotBlank(
        message: 'Message is required.'
    )]
    #[Assert\Length(
        min: 10,
        minMessage: 'Message must be at least {{ limit }} characters.'
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    #[PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
}
