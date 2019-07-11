<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use \DateTime;

/**
 * @ORM\Entity
 */
class Person
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
    private $name;

    /**
     * @ORM\Column(type="enum_person")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $cpf;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $cnpj;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\Column(type="enum_gender", nullable=true)
     */
    private $gender;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="peopleCreated")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userCreated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="peopleUpdated")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Supplier", mappedBy="person", orphanRemoval=true)
     */
    private $suppliers;

    public function __construct($data=[])
    {
        $this->suppliers = new ArrayCollection();

        $this->createdAt = new DateTime('now');
        $this->updatedAt = new DateTime('now');
        $this->load($data);
    }

    public function load($data=[]) 
    {
        if (isset($data->birthdate)) {
            if ($data->birthdate instanceof DateTime) {
                $this->birthdate = $data->birthdate;
            } else {
                $this->birthdate = new DateTime($data->birthdate);
            }
        }

        $this->name = isset($data->name) ? $data->name : $this->name;
        $this->type = isset($data->type) ? $data->type : $this->type;
        $this->company = isset($data->company) ? $data->company : $this->company;
        $this->cpf = isset($data->cpf) ? $data->cpf : $this->cpf;
        $this->cnpj = isset($data->cnpj) ? $data->cnpj : $this->cnpj;
        $this->email = isset($data->email) ? $data->email : $this->email;
        //$this->birthdate = isset($data->birthdate) ? $data->birthdate : $this->birthdate;
        $this->gender = isset($data->gender) ? $data->gender : $this->gender;
        $this->createdAt = isset($data->createdAt) ? $data->createdAt : $this->createdAt;
        $this->updatedAt = isset($data->updatedAt) ? $data->updatedAt : $this->updatedAt;
    }

    public function toJSON() {
        return [
            "name" => $this->name,
            "type" => $this->type,
            "company" => $this->company,
            "cpf" => $this->cpf,
            "cnpj" => $this->cnpj,
            "email" => $this->email,
            "birthdate" => $this->birthdate,
            "gender" => $this->gender,
            "userCreated" => $this->userCreated->toJSON(),
            "userUpdated" => $this->userUpdated->toJSON(),
            "createdAt"   => $this->createdAt->format('d-m-Y'),
            "updatedAt"   => $this->updatedAt->format('d-m-Y')
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(?string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(?string $cnpj): self
    {
        $this->cnpj = $cnpj;

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

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

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
     * @return Collection|Supplier[]
     */
    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function addSupplier(Supplier $supplier): self
    {
        if (!$this->suppliers->contains($supplier)) {
            $this->suppliers[] = $supplier;
            $supplier->setPerson($this);
        }

        return $this;
    }

    public function removeSupplier(Supplier $supplier): self
    {
        if ($this->suppliers->contains($supplier)) {
            $this->suppliers->removeElement($supplier);
            // set the owning side to null (unless already changed)
            if ($supplier->getPerson() === $this) {
                $supplier->setPerson(null);
            }
        }

        return $this;
    }
}
