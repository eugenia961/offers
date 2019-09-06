<?php

namespace App\Utils;

use App\Interfaces\WriterInterface;
use App\Interfaces\OfferInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Offer;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DataBaseWriter implements WriterInterface {

    private $entityManagerInterface;

    public function __construct(EntityManagerInterface $entityManagerInterface) {

        $this->entityManagerInterface = $entityManagerInterface;
    }

    public function save($iterator): void {
        try {

            foreach ($iterator as $offer) {

                $this->entityManagerInterface->persist($offer);
            }

            $this->entityManagerInterface->flush();
            $this->entityManagerInterface->clear();
            
        } catch (\Exception $e) {

            //\print_r( $e->getMessage());
            throw new HttpException(\Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR
            , \sprintf("Duplicate offer name: %s ", $offer->getName()));
        }
    }

}
