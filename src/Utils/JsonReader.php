<?php

namespace App\Utils;

use GuzzleHttp\Client;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;

use App\Entity\Offer;
use App\Interfaces\ReaderInterface;
use App\ValidObjects\OfferValidObject;
use App\Interfaces\VendorRepositoryInterface;
use App\Interfaces\OfferRepositoryInterface;

class JsonReader implements ReaderInterface {

    private $vendorRepositoryInterface;
    private $offerRepositoryInterface;

    public function __construct(VendorRepositoryInterface $vendorRepositoryInterface, OfferRepositoryInterface $offerRepositoryInterface) {

        $this->vendorRepositoryInterface = $vendorRepositoryInterface;
        $this->offerRepositoryInterface = $offerRepositoryInterface;
    }

    public function read(string $input) {

        $json = \json_decode($input, true);

        $offerCollection = new ArrayCollection();

        if ($json != null) {

            foreach ($json as $offerValues) {

                $offerValidObject = new OfferValidObject($this->offerRepositoryInterface
                        , $this->vendorRepositoryInterface
                        , $offerValues['name']
                        , $offerValues['quantity']
                        , $offerValues['offer_date']
                        , $offerValues['price']
                        , $offerValues['vendor']['name']);

                $id = Uuid::uuid4()->toString();
                $offer = Offer::created($id
                                , $offerValidObject->name()
                                , $offerValidObject->date()
                                , $offerValidObject->quantity()
                                , $offerValidObject->price()
                                , $offerValidObject->vendor());

                $offerCollection->add($offer);
            }
        }

        return $offerCollection;
    }

    public function getUrlDataSrc($method, $url): string {

        $client = new Client();
        $response = $client->request($method, $url);

        $response->getStatusCode(); # 200
        $response->getHeaderLine('application/json; charset=utf8'); # 'application/json; charset=utf8  

        return $response->getBody();
    }

}
