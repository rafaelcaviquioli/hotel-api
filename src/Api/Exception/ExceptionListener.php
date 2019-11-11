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
            'message' => $exception->getMessage(),
            'exceptionName' => self::getClassName($exception),
        ];
        $response = new JsonResponse($responseData, $exception->getCode());

        $event->setResponse($response);
    }

    private static function getClassName(object $class): string
    {
        $explodeNameSpace = explode("\\", get_class($class));
        return end($explodeNameSpace);
    }
}
