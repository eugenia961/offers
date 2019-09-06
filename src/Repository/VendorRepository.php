<?php

namespace App\Repository;

use App\Entity\Vendor;
use App\Interfaces\VendorRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Vendor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vendor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vendor[]    findAll()
 * @method Vendor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VendorRepository extends ServiceEntityRepository implements VendorRepositoryInterface {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Vendor::class);
    }

    public function findById($id) {

        return $this->createQueryBuilder('v')
                        ->andWhere('v.id = :id')
                        ->setParameter('id', $id)
                        ->getQuery()
                        ->getOneOrNullResult();
    }

    public function save($vendor) {

        $this->getEntityManager()->persist($vendor);
        $this->getEntityManager()->flush();
    }

    public function findByName($name) {
        
        return $this->createQueryBuilder('v')
                        ->andWhere('v.name = :name')
                        ->setParameter('name', $name)
                        ->getQuery()
                        ->getOneOrNullResult();
    }

    // /**
    //  * @return Vendor[] Returns an array of Vendor objects
    //  */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('v')
      ->andWhere('v.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('v.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */

    /*
      public function findOneBySomeField($value): ?Vendor
      {
      return $this->createQueryBuilder('v')
      ->andWhere('v.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */
}
