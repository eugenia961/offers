<?php

namespace App\Utils;

use App\Interfaces\VendorRepositoryInterface;

final class VendorSearch {

    private $vendorRepositoryInterface;

    public function __construct(VendorRepositoryInterface $vendorRepositoryInterface) {

        $this->vendorRepositoryInterface = $vendorRepositoryInterface;
    }

    public function __invoke($name) {
        
        $vendor = $this->vendorRepositoryInterface->findByName($name);
        
       
        return $vendor;
    }

}
