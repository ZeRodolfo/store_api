<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use \DateTime;

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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="suppliersCreated")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userCreated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="suppliersUpdated")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userUpdated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Address", mappedBy="supplier")
     */
    private $address;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    public function __construct($data=[])
    {
        $this->address = new ArrayCollection();

        $this->active = true;
        $this->createdAt = new DateTime('now');
        $this->updatedAt = new DateTime('now');
        $this->load($data);
    }

    public function load($data=[]) {
        $this->email = isset($data->email) ? $data->email : $this->email;
        $this->contactName = isset($data->contactName) ? $data->contactName : $this->contactName;
        $this->active = isset($data->active) ? $data->active : $this->active;
        $this->sendEmailServiceOrder = isset($data->sendEmailServiceOrder) ? $data->sendEmailServiceOrder : $this->sendEmailServiceOrder;
        $this->createdAt = isset($data->createdAt) ? $data->createdAt : $this->createdAt;
        $this->updatedAt = isset($data->updatedAt) ? $data->updatedAt : $this->updatedAt;
    }

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

    public function getUserCreated(): ?User
    {
        return $this->userCreated;
    }

    public function setUserCreated(?User $userCreated): self
    {
        $this->userCreated = $userCreated;

        return $this;
    }

    public function getUserUpdated(): ?User
    {
        return $this->userUpdated;
    }

    public function setUserUpdated(?User $userUpdated): self
    {
        $this->userUpdated = $userUpdated;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->address->contains($address)) {
            $this->address[] = $address;
            $address->setSupplier($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->address->contains($address)) {
            $this->address->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getSupplier() === $this) {
                $address->setSupplier(null);
            }
        }

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
