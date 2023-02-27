<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;

class CouldNotSendNotification extends Exception
{
    /**
     * @return static
     */
    public static function serviceRespondedWithAnHttpError(ResponseInterface $response)
    {
        $message = "Discord responded with an HTTP error: {$response->getStatusCode()}";

        if ($error = Arr::get(json_decode($response->getBody(), true), 'message')) {
            $message .= ": $error";
        }

        return new static($message);
    }

    /**
     * @param  array  $response
     * @return static
     */
    public static function serviceRespondedWithAnApiError($response)
    {
        return new static("Discord responded with an API error: {$response['code']}: {$response['message']}");
    }

    /**
     * @return static
     */
    public static function serviceCommunicationError(Exception $exception)
    {
        return new static("Communication with Discord failed: {$exception->getCode()}: {$exception->getMessage()}");
    }
}
