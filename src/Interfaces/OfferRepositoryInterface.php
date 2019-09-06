<?php

namespace App\Interfaces;

interface OfferRepositoryInterface {

    public function save($offer);

    public function findById($id);

    public function findByDates($dateRange);

    public function findByPrices($priceRange);
    
    public function findByName($name);
    
    public function findByVendorName($name);
}
