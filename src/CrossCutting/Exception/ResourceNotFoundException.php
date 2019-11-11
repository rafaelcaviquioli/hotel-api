<?php

namespace App\CrossCutting\Exception;

use Symfony\Component\HttpFoundation\Response;

class ResourceNotFoundException extends \Exception implements IResponseException
{
    public function __construct(string $message = "Resource not found")
    {
        parent::__construct($message, Response::HTTP_NOT_FOUND);
    }
}
