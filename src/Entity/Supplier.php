<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Supplier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="suppliers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sendEmailServiceOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(?string $contactName): self
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getSendEmailServiceOrder(): ?bool
    {
        return $this->sendEmailServiceOrder;
    }

    public function setSendEmailServiceOrder(bool $sendEmailServiceOrder): self
    {
        $this->sendEmailServiceOrder = $sendEmailServiceOrder;

        return $this;
    }
}
