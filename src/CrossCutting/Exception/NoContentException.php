<?php

namespace App\CrossCutting\Exception;

use Symfony\Component\HttpFoundation\Response;

class NoContentException extends \Exception implements IResponseException
{
    public function __construct(string $message = "No content")
    {
        parent::__construct($message, Response::HTTP_NO_CONTENT);
    }
}
