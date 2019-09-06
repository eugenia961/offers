<?php

namespace App\Utils;

use App\Interfaces\OfferRepositoryInterface;

final class OfferSearch {

    private $offerRepositoryInterface;

    public function __construct(OfferRepositoryInterface $offerRepositoryInterface) {
        $this->offerRepositoryInterface = $offerRepositoryInterface;
    }

    public function __invoke($name) {

        $offer = $this->offerRepositoryInterface->findByName($name);

        return $offer;
      
    }

}
