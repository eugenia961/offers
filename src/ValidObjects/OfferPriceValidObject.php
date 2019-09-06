<?php

namespace App\ValidObjects;

use App\Exceptions\BadRequestException;

class OfferPriceValidObject {

    private $pricesRanges;

    public function __construct($pricesRanges) {

        $this->ragenPriceValid($pricesRanges);

        $this->pricesRanges = $pricesRanges;
    }

    public function value() {

        return $this->pricesRanges;
    }

    private function ragenPriceValid($pricesRanges) {

        $startPrice = $pricesRanges['startPrice'];
        $endPrice = $pricesRanges['endPrice'];

        if ($endPrice < $startPrice) {

            $badRequestException = new BadRequestException();
            $badRequestException('The end price must be greater than the start price');
        }
    }

}
