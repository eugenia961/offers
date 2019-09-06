<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 * @ORM\Table(name="offers")
 * @UniqueEntity("name")
 */
class Offer {

    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vendor", inversedBy="offert")
     */
    private $vendor;

    public function __construct($id, $name, $date, $quantity, $price, $vendor) {

        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->vendor = $vendor;
    }

    public static function created($id, $name, $date, $quantity, $price, $vendor) {

        $offer = new static($id, $name, new \DateTime($date), $quantity, $price, $vendor);

        return $offer;
    }

    public function id() {
        return $this->id;
    }

    public function name() {
        return $this->name;
    }

    public function date() {
        return $this->date;
    }

    public function quantity() {
        return $this->quantity;
    }

    public function price() {
        return $this->price;
    }

    public function vendor() {
        return $this->vendor;
    }

}
