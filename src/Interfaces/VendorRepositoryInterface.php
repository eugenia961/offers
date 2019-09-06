<?php

namespace App\Interfaces;

interface VendorRepositoryInterface {

    public function save($vendor);

    public function findById($id);

    public function findByName($name);
}
