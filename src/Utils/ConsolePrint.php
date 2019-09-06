<?php

namespace App\Utils;

use App\Interfaces\OfferPrintInterface;

class ConsolePrint implements OfferPrintInterface {

    public function printHeader($header) {

        $header_line = \str_repeat("=", \strlen($header));
        return $header_line;
    }

    public function printOffer($offers, $table, $errorMessages) {

        if (\count($offers) == 0) {

            $serverException = new ServerException();
            $serverException->__invoke($errorMessages);
        }

        foreach ($offers as $offer) {

            $string_date = $offer->date()->format("Y-m-d H:i:s");
            $rows[] = [$offer->id(), $offer->name(), $string_date, $offer->quantity(), $offer->price()];
        }

        $table->setHeaders(['Id', 'Name', 'Offer date', 'Quantity', 'Price'])
                ->setRows($rows)
                ->render();
    }

}
