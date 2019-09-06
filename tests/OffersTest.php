<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Offer;
use App\Entity\Vendor;
use App\ValidObjects\DateRangesValidObject;

class OffersTest extends KernelTestCase {

    /** @var \Doctrine\ORM\EntityManager */
    private $entityManager;

    protected function setUp() {


        $kernel = self::bootKernel();
        $this->entityManager = $kernel
                ->getContainer()
                ->get('doctrine')
                ->getManager();
    }

    protected function tearDown() {

        $this->offerRepositoryMock = null;
    }

    public function testOfferVendor() {

        $vendorName = "Vendor 2";

        $vendor = Vendor::created("f213e518-cfd9-11e9-b9b8-a0a4c59e58b3", $vendorName);

        $offer = Offer::created("f5c50b18-cfd9-11e9-b9b8-a0a4c59e58b3", "offer 2", "2019-08-20 15:00:00", "10", "0.0", $vendor);

        $offersVendorArray = $this->entityManager
                ->getRepository(Offer::class)
                ->findByVendorName($vendorName);

        $this->assertCount(1, $offersVendorArray);
        $this->assertContains($offersVendorArray[0]->name(), $offer->name());
    }

    public function testOfferByName() {

        $name = "offer 2";

        $vendor = Vendor::created("f213e518-cfd9-11e9-b9b8-a0a4c59e58b3", "Vendor 2");

        $offer = Offer::created("f5c50b18-cfd9-11e9-b9b8-a0a4c59e58b3", "offer 2", "2019-08-20 15:00:00", "10", "0.0", $vendor);

        $offerRepository = $this->entityManager
                ->getRepository(Offer::class)
                ->findByName($name);

        $this->assertContains($offerRepository->name(), $offer->name());
    }

    public function testDateValidation() {
        $dateRanges = [
            'startDate' => "2019-01-01 00:00:00",
            'endDate' => "2019-12-01 00:00:00"
        ];

        $dateRangesValidObject = new DateRangesValidObject($dateRanges);
        $dateRangeObject = $dateRangesValidObject->value();

        $startDate = $dateRangeObject['startDate'];
        $endDate = $dateRangeObject['endDate'];

        $this->assertEquals($dateRanges['startDate'], $startDate->format("Y-m-d H:i:s"));
        $this->assertEquals($dateRanges['endDate'], $endDate->format("Y-m-d H:i:s"));
    }

    public function testOfferByDates() {

        $dateRanges = [
            'startDate' => "2019-01-01 00:00:00",
            'endDate' => "2019-12-01 00:00:00"
        ];

        $dateRangesValidObject = new DateRangesValidObject($dateRanges);
        $dateRangeObject = $dateRangesValidObject->value();

        $vendor = Vendor::created("f213e518-cfd9-11e9-b9b8-a0a4c59e58b3", "Vendor 2");

        $offer = Offer::created("f5c50b18-cfd9-11e9-b9b8-a0a4c59e58b3", "offer 2", "2019-08-20 15:00:00", "10", "0.0", $vendor);

        $offerRepository = $this->entityManager
                ->getRepository(Offer::class)
                ->findByDates($dateRangeObject);

        $this->assertCount(3, $offerRepository);
        $this->assertContains($offerRepository[1]->name(), $offer->name());
    }

    public function testOfferNotFound() {

        $vendorName = "Vendor 50";


        $offersVendorArray = $this->entityManager
                ->getRepository(Offer::class)
                ->findByVendorName($vendorName);

        $this->assertCount(0, $offersVendorArray);
    }

}
