<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use \DateTime;

/**
 * @ORM\Entity
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $district;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $complement;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="adressesCreated")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userCreated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="adressesUpdated")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Supplier", inversedBy="address")
     */
    private $supplier;

    public function __construct($data=[]) 
    {
        $this->createdAt = new DateTime('now');
        $this->updatedAt = new DateTime('now');

        $this->load($data);
    }

    public function load($data=[]) {
        $this->street = isset($data->street) ? $data->street : $this->street;
        $this->district = isset($data->district) ? $data->district : $this->district;
        $this->number = isset($data->number) ? $data->number : $this->number;
        $this->postalCode = isset($data->postalCode) ? $data->postalCode : $this->postalCode;
        $this->complement = isset($data->complement) ? $data->complement : $this->complement;
        $this->note = isset($data->note) ? $data->note : $this->note;
        $this->createdAt = isset($data->createdAt) ? $data->createdAt : $this->createdAt;
        $this->updatedAt = isset($data->updatedAt) ? $data->updatedAt : $this->updatedAt;
    }
		
    public function toJSON() {
        $supplier = $this->supplier !== NULL ? $this->supplier->toJSON() : NULL;

        return [
            "id"    => $this->id,
            "street"  => $this->street,
            "district" => $this->district,
            "number" => $this->number,
            "postalCode" => $this->postalCode,
            "complement" => $this->complement,
            "note" => $this->note,
            "userCreated" => $this->userCreated->toJSON(),
            "userUpdated" => $this->userUpdated->toJSON(),
            "createdAt"   => $this->createdAt->format('d-m-Y'),
            "updatedAt"   => $this->updatedAt->format('d-m-Y'),
            "supplier" => $supplier,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(string $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function setComplement(?string $complement): self
    {
        $this->complement = $complement;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

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

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }
}
