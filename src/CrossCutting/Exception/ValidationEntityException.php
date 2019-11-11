<?php

namespace App\CrossCutting\Exception;

use Symfony\Component\HttpFoundation\Response;

class ValidationEntityException extends \Exception implements IResponseException
{
    public function __construct(string $message = "Bad request")
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }
}
