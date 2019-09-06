<?php

namespace App\Interfaces;

interface OfferPrintInterface {

    public function printOffer($offers,$table,$errorMessages);

    public function printHeader($header);
}
