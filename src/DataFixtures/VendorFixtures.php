<?php

namespace App\DataFixtures;

use Ramsey\Uuid\Uuid;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Vendor;


class VendorFixtures extends Fixture {

    public function load(ObjectManager $manager) {

        $this->loadVendorFixtures($manager);
        $manager->flush();
    }

    public function loadVendorFixtures(ObjectManager $manager) {

        for ($i = 1; $i < 4; $i++) {

            $id = Uuid::uuid4()->toString();
            $vendor = Vendor::created($id, "Vendor $i");
            $manager->persist($vendor);
        }
    }

}
