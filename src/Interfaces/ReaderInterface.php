<?php

namespace App\Interfaces;

interface ReaderInterface {

//
    public function read(string $input);

    public function getUrlDataSrc($method, $url);
}
