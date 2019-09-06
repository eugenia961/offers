<?php

namespace App\ValidObjects;

use App\Utils\OfferSearch;
use App\Utils\VendorSearch;
use App\Exceptions\ServerException;
use App\Interfaces\OfferRepositoryInterface;
use App\Interfaces\VendorRepositoryInterface;

final class OfferValidObject {

    private $name;
    private $quantity;
    private $date;
    private $price;
    private $vendor;
    private $vendorName;
    private $serverException;
    private $offerRepositoryInterface;
    private $vendorRepositoryInterface;

    public function __construct(OfferRepositoryInterface $offerRepositoryInterface
    , VendorRepositoryInterface $vendorRepositoryInterface, $name, $quantity, $date, $price, $vendorName) {

        $this->serverException = new ServerException();
        $this->offerRepositoryInterface = $offerRepositoryInterface;
        $this->vendorRepositoryInterface = $vendorRepositoryInterface;

        $this->name = $name;
        $this->quantity = $quantity;
        $this->date = $date;
        $this->price = $price;
        $this->vendorName = $vendorName;

        $this->isValid();
    }

    private function isValid() {

        $this->priceIsValid();
        $this->dateIsValid();
        $this->quantityIsValid();
        $this->nameIsValid();
        $this->offerIsValid();
    }

    private function priceIsValid() {

        if (!\is_numeric($this->price)) {

            $this->serverException->__invoke(\sprintf("The price is not a valid float %s", $this->price));
        }

        if ($this->price < 0) {

            $this->serverException->__invoke(\sprintf("The price %s  should greater than 0 or equal to 0 ", $this->price));
        }
    }

    private function dateIsValid() {

        $format = 'Y-m-d H:i:s';

        $d = \DateTime::createFromFormat($format, $this->date);

        if (!($d && $d->format($format) == $this->date)) {
            $this->serverException->__invoke(\sprintf("This value is not a valid datetime  %s", $this->date));
        }
    }

    private function quantityIsValid() {

        if (!\is_int($this->quantity)) {

            $this->serverException->__invoke(\sprintf("The quantity is not a valid integer %s", $this->quantity));
        }


        if ($this->quantity < 0) {

            $this->serverException->__invoke(\sprintf("The quantity %s should greater than 0", $this->quantity));
        }
    }

    private function nameIsValid() {

        if (\strlen(\trim($this->name)) == 0) {
            $this->serverException->__invoke("The name should not be blank");
        }
    }

    private function offerIsValid() {

        $OfferSearch = new OfferSearch($this->offerRepositoryInterface);
        $offer = $OfferSearch->__invoke($this->name);

        if ($offer) {

            $this->serverException->__invoke(sprintf("Offer %s already exist", $offer->name()));
        }

        $vendorSearch = new VendorSearch($this->vendorRepositoryInterface);
        $vendor = $vendorSearch->__invoke($this->vendorName);

        if ($vendor == null) {

            $this->serverException->__invoke(sprintf("Offer %s already exist", "Vendor not found"));
        }

        $this->vendor = $vendor;
    }

    public function name() {
        return $this->name;
    }

    public function quantity() {
        return $this->quantity;
    }

    public function date() {
        return $this->date;
    }

    public function price() {
        return $this->price;
    }

    public function vendor() {
        return $this->vendor;
    }

}
