<?php

namespace App\Repository;

use App\Entity\Offer;
use App\Interfaces\OfferRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository implements OfferRepositoryInterface {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Offer::class);
    }

    public function findById($id) {

        $query_builder = $this->createQueryBuilder("o");

        return $query_builder
                        ->where("o.vendor=:id")
                        ->andWhere(
                                $query_builder->expr()->gt("o.quantity", ":quantity")
                        )
                        ->setParameter("id", $id)
                        ->setParameter("quantity", 0)
                        ->getQuery()
                        ->getOneOrNullResult();
    }

    public function findByName($name) {

        return $this->createQueryBuilder("o")
                        ->where("o.name=:name")
                        ->setParameter("name", $name)
                        ->getQuery()
                        ->getOneOrNullResult();
    }

    public function findByDates($dateRange) {

        $startDate = $dateRange['startDate'];
        $endDate = $dateRange['endDate'];

        $query_builder = $this->createQueryBuilder("o");

        return $query_builder
                        ->where('o.date BETWEEN :start_date AND :end_date')
                        ->andWhere(
                                $query_builder->expr()->gt("o.quantity", ":quantity")
                        )
                        ->setParameter("start_date", $startDate->format("Y-m-d H:i:s"))
                        ->setParameter("end_date", $endDate->format("Y-m-d H:i:s"))
                        ->setParameter("quantity", 0)
                        ->orderBy("o.date", "DESC")
                        ->getQuery()
                        ->getResult();
    }

    public function findByVendorName($name) {

        $query_builder = $this->createQueryBuilder("o");

        return $query_builder
                        ->join("o.vendor", "v")
                        ->where('v.name = :name')
                        ->setParameter("name", $name)
                        ->orderBy("o.date", "DESC")
                        ->getQuery()
                        ->getResult();
    }

    public function findByPrices($pricesRange) {

        $startPrice = $pricesRange['startPrice'];
        $endPrice = $pricesRange['endPrice'];

        $query_builder = $this->createQueryBuilder("o");

        return $query_builder
                        ->where('o.price BETWEEN :start_price AND :end_price')
                        ->andWhere(
                                $query_builder->expr()->gt("o.quantity", ":quantity")
                        )
                        ->setParameter("start_price", $startPrice)
                        ->setParameter("end_price", $endPrice)
                        ->setParameter("quantity", 0)
                        ->orderBy("o.date", "DESC")
                        ->getQuery()
                        ->getResult();
    }

    public function save($offer) {

        $this->getEntityManager()->persist($offer);
        $this->getEntityManager()->flush();
    }

}
