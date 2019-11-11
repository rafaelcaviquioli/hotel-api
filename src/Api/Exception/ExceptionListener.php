<?php

namespace App\Api\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use App\CrossCutting\Exception\IResponseException;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof IResponseException) {
            return;
        }

        $responseData = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ];

        $event->setResponse(
            new JsonResponse($responseData, $responseData['code'])
        );
    }
}
