<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {
  /** 
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Brand", mappedBy="userCreated")
   */
  private $brandsCreated;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Brand", mappedBy="userUpdated")
   */
  private $brandsUpdated;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="userCreated")
   */
  private $categoriesCreated;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="userUpdated")
   */
  private $categoriesUpdated;

  /**

   * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="userCreated")
   */
  private $productsCreated;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="userUpdated")
   */
  private $productsUpdated;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Person", mappedBy="userCreated", orphanRemoval=true)
   */
  private $peopleCreated;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Person", mappedBy="userUpdated", orphanRemoval=true)
   */
  private $peopleUpdated;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Supplier", mappedBy="userCreated", orphanRemoval=true)
   */
  private $suppliersCreated;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Supplier", mappedBy="userUpdated", orphanRemoval=true)
   */
  private $suppliersUpdated;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Address", mappedBy="userCreated", orphanRemoval=true)
   */
  private $adressesCreated;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Address", mappedBy="userUpdated", orphanRemoval=true)
   */
  private $adressesUpdated;


  public function __construct() {
    parent::__construct();
    $this->brandsCreated = new ArrayCollection();
    $this->brandsUpdated = new ArrayCollection();
    $this->categoriesCreated = new ArrayCollection();
    $this->categoriesUpdated = new ArrayCollection();
    $this->productsCreated = new ArrayCollection();
    $this->productsUpdated = new ArrayCollection();
    $this->peopleCreated = new ArrayCollection();
    $this->peopleUpdated = new ArrayCollection();
    $this->suppliersCreated = new ArrayCollection();
    $this->suppliersUpdated = new ArrayCollection();
    $this->adressesCreated = new ArrayCollection();
    $this->adressesUpdated = new ArrayCollection();
  }

  public function toJSON() {
    return [
      "id"    => $this->id,
      "username"  => $this->username,
    ];
  }

  public function getRoles(): array
  {
    $roles = $this->roles;
    // guarantee every user at least has ROLE_USER
    $roles[] = 'ROLE_ADMIN';

    return array_unique($roles);
  }

  /**
   * @return Collection|Brand[]
   */
  public function getBrandsCreated(): Collection
  {
      return $this->brandsCreated;
  }

  public function addBrandsCreated(Brand $brandsCreated): self
  {
      if (!$this->brandsCreated->contains($brandsCreated)) {
          $this->brandsCreated[] = $brandsCreated;
          $brandsCreated->setUserCreated($this);
      }

      return $this;
  }

  public function removeBrandsCreated(Brand $brandsCreated): self
  {
      if ($this->brandsCreated->contains($brandsCreated)) {
          $this->brandsCreated->removeElement($brandsCreated);
          // set the owning side to null (unless already changed)
          if ($brandsCreated->getUserCreated() === $this) {
              $brandsCreated->setUserCreated(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection|Brand[]
   */
  public function getBrandsUpdated(): Collection
  {
      return $this->brandsUpdated;
  }

  public function addBrandsUpdated(Brand $brandsUpdated): self
  {
      if (!$this->brandsUpdated->contains($brandsUpdated)) {
          $this->brandsUpdated[] = $brandsUpdated;
          $brandsUpdated->setUserUpdated($this);
      }

      return $this;
  }

  public function removeBrandsUpdated(Brand $brandsUpdated): self
  {
      if ($this->brandsUpdated->contains($brandsUpdated)) {
          $this->brandsUpdated->removeElement($brandsUpdated);
          // set the owning side to null (unless already changed)
          if ($brandsUpdated->getUserUpdated() === $this) {
              $brandsUpdated->setUserUpdated(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection|Category[]
   */
  public function getCategoriesCreated(): Collection
  {
      return $this->categoriesCreated;
  }

  public function addCategoriesCreated(Category $categoriesCreated): self
  {
      if (!$this->categoriesCreated->contains($categoriesCreated)) {
          $this->categoriesCreated[] = $categoriesCreated;
          $categoriesCreated->setUserCreated($this);
      }

      return $this;
  }

  public function removeCategoriesCreated(Category $categoriesCreated): self
  {
      if ($this->categoriesCreated->contains($categoriesCreated)) {
          $this->categoriesCreated->removeElement($categoriesCreated);
          // set the owning side to null (unless already changed)
          if ($categoriesCreated->getUserCreated() === $this) {
              $categoriesCreated->setUserCreated(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection|Category[]
   */
  public function getCategoriesUpdated(): Collection
  {
      return $this->categoriesUpdated;
  }

  public function addCategoriesUpdated(Category $categoriesUpdated): self
  {
      if (!$this->categoriesUpdated->contains($categoriesUpdated)) {
          $this->categoriesUpdated[] = $categoriesUpdated;
          $categoriesUpdated->setUserUpdated($this);
      }

      return $this;
  }

  public function removeCategoriesUpdated(Category $categoriesUpdated): self
  {
      if ($this->categoriesUpdated->contains($categoriesUpdated)) {
          $this->categoriesUpdated->removeElement($categoriesUpdated);
          // set the owning side to null (unless already changed)
          if ($categoriesUpdated->getUserUpdated() === $this) {
              $categoriesUpdated->setUserUpdated(null);
          }
      }

      return $this;
  }

  /**
<<<<<<< HEAD
   * @return Collection|Product[]
   */
  public function getProductsCreated(): Collection
  {
      return $this->productsCreated;
  }

  public function addProductsCreated(Product $productsCreated): self
  {
      if (!$this->productsCreated->contains($productsCreated)) {
          $this->productsCreated[] = $productsCreated;
          $productsCreated->setUserCreated($this);
      }
    }
    /**
   * @return Collection|Person[]
   */
  public function getPeopleCreated(): Collection
  {
      return $this->peopleCreated;
  }

  public function addPeopleCreated(Person $peopleCreated): self
  {
      if (!$this->peopleCreated->contains($peopleCreated)) {
          $this->peopleCreated[] = $peopleCreated;
          $peopleCreated->setUserCreated($this);
      }

      return $this;
  }


  public function removeProductsCreated(Product $productsCreated): self
  {
      if ($this->productsCreated->contains($productsCreated)) {
          $this->productsCreated->removeElement($productsCreated);
          // set the owning side to null (unless already changed)
          if ($productsCreated->getUserCreated() === $this) {
              $productsCreated->setUserCreated(null);
          }
        }
    }

  public function removePeopleCreated(Person $peopleCreated): self
  {
      if ($this->peopleCreated->contains($peopleCreated)) {
          $this->peopleCreated->removeElement($peopleCreated);
          // set the owning side to null (unless already changed)
          if ($peopleCreated->getUserCreated() === $this) {
              $peopleCreated->setUserCreated(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection|Product[]
   */
  public function getProductsUpdated(): Collection
  {
      return $this->productsUpdated;
  }

  public function addProductsUpdated(Product $productsUpdated): self
  {
      if (!$this->productsUpdated->contains($productsUpdated)) {
          $this->productsUpdated[] = $productsUpdated;
          $productsUpdated->setUserUpdated($this);

      }
    }
    /**
   * @return Collection|Person[]
   */
  public function getPeopleUpdated(): Collection
  {
      return $this->peopleUpdated;
  }

  public function addPeopleUpdated(Person $peopleUpdated): self
  {
      if (!$this->peopleUpdated->contains($peopleUpdated)) {
          $this->peopleUpdated[] = $peopleUpdated;
          $peopleUpdated->setUserUpdated($this);
      }

      return $this;
  }

  public function removeProductsUpdated(Product $productsUpdated): self
  {
      if ($this->productsUpdated->contains($productsUpdated)) {
          $this->productsUpdated->removeElement($productsUpdated);
          // set the owning side to null (unless already changed)
          if ($productsUpdated->getUserUpdated() === $this) {
              $productsUpdated->setUserUpdated(null);
          }
        }
    }

  public function removePeopleUpdated(Person $peopleUpdated): self
  {
      if ($this->peopleUpdated->contains($peopleUpdated)) {
          $this->peopleUpdated->removeElement($peopleUpdated);
          // set the owning side to null (unless already changed)
          if ($peopleUpdated->getUserUpdated() === $this) {
              $peopleUpdated->setUserUpdated(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection|Supplier[]
   */
  public function getSuppliersCreated(): Collection
  {
      return $this->suppliersCreated;
  }

  public function addSuppliersCreated(Supplier $suppliersCreated): self
  {
      if (!$this->suppliersCreated->contains($suppliersCreated)) {
          $this->suppliersCreated[] = $suppliersCreated;
          $suppliersCreated->setUserCreated($this);
      }

      return $this;
  }

  public function removeSuppliersCreated(Supplier $suppliersCreated): self
  {
      if ($this->suppliersCreated->contains($suppliersCreated)) {
          $this->suppliersCreated->removeElement($suppliersCreated);
          // set the owning side to null (unless already changed)
          if ($suppliersCreated->getUserCreated() === $this) {
              $suppliersCreated->setUserCreated(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection|Supplier[]
   */
  public function getSuppliersUpdated(): Collection
  {
      return $this->suppliersUpdated;
  }

  public function addSuppliersUpdated(Supplier $suppliersUpdated): self
  {
      if (!$this->suppliersUpdated->contains($suppliersUpdated)) {
          $this->suppliersUpdated[] = $suppliersUpdated;
          $suppliersUpdated->setUserUpdated($this);
      }

      return $this;
  }

  public function removeSuppliersUpdated(Supplier $suppliersUpdated): self
  {
      if ($this->suppliersUpdated->contains($suppliersUpdated)) {
          $this->suppliersUpdated->removeElement($suppliersUpdated);
          // set the owning side to null (unless already changed)
          if ($suppliersUpdated->getUserUpdated() === $this) {
              $suppliersUpdated->setUserUpdated(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection|Address[]
   */
  public function getAdressesCreated(): Collection
  {
      return $this->adressesCreated;
  }

  public function addAdressesCreated(Address $adressesCreated): self
  {
      if (!$this->adressesCreated->contains($adressesCreated)) {
          $this->adressesCreated[] = $adressesCreated;
          $adressesCreated->setUserCreated($this);
      }

      return $this;
  }

  public function removeAdressesCreated(Address $adressesCreated): self
  {
      if ($this->adressesCreated->contains($adressesCreated)) {
          $this->adressesCreated->removeElement($adressesCreated);
          // set the owning side to null (unless already changed)
          if ($adressesCreated->getUserCreated() === $this) {
              $adressesCreated->setUserCreated(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection|Address[]
   */
  public function getAdressesUpdated(): Collection
  {
      return $this->adressesUpdated;
  }

  public function addAdressesUpdated(Address $adressesUpdated): self
  {
      if (!$this->adressesUpdated->contains($adressesUpdated)) {
          $this->adressesUpdated[] = $adressesUpdated;
          $adressesUpdated->setUserUpdated($this);
      }

      return $this;
  }

  public function removeAdressesUpdated(Address $adressesUpdated): self
  {
      if ($this->adressesUpdated->contains($adressesUpdated)) {
          $this->adressesUpdated->removeElement($adressesUpdated);
          // set the owning side to null (unless already changed)
          if ($adressesUpdated->getUserUpdated() === $this) {
              $adressesUpdated->setUserUpdated(null);
          }
      }

      return $this;
  }
}