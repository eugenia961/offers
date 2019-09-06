<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ServerException extends \Exception {

    public function __invoke($message) {
       
        throw new HttpException(\Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR, $message);
    }

}
