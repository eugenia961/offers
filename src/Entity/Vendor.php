<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VendorRepository")
 * @ORM\Table(name="vendors")
 */
class Vendor {

    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offer", mappedBy="vendor")
     */
    private $offert;

    public function __construct($id, $name, $offerts) {

        $this->id = $id;
        $this->name = $name;
        $this->offert = $offerts;
    }

    public static function created($id, $name) {

        $vendor = new static($id, $name, new ArrayCollection());

        return $vendor;
    }

    public function id() {
        return $this->id;
    }

    public function name() {
        return $this->name;
    }

    /**
     * @return Collection|Offer[]
     */
    public function offert(): Collection {
        return $this->offert;
    }

    public function addOffert(Offer $offert): self {
        if (!$this->offert->contains($offert)) {
            $this->offert[] = $offert;
            $offert->setVendor($this);
        }

        return $this;
    }

    public function removeOffert(Offer $offert): self {
        if ($this->offert->contains($offert)) {
            $this->offert->removeElement($offert);
// set the owning side to null (unless already changed)
            if ($offert->getVendor() === $this) {
                $offert->setVendor(null);
            }
        }

        return $this;
    }

}
