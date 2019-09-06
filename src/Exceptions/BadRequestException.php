<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BadRequestException extends \Exception {

    public function __invoke($messages) {
        
        throw new BadRequestHttpException($messages);
    }

}
