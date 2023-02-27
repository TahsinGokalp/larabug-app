<?php

namespace App\Notifications\Discord;

use App\Exceptions\CouldNotSendNotification;
use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;

class Discord
{
    /** @var string */
    protected $baseUrl = 'https://discordapp.com/api';

    /** @var \GuzzleHttp\Client */
    protected $httpClient;

    public function __construct(HttpClient $http)
    {
        $this->httpClient = $http;
    }

    /**
     * @return array
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send($notifiable, string $route, array $data)
    {
        return $this->request('POST', $route, $data);
    }

    /**
     * @param  mixed  $user
     * @return string
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPrivateChannel($user)
    {
        return $this->request('POST', 'users/@me/channels', ['recipient_id' => $user])['id'];
    }

    /**
     * @param  string  $endpoint
     * @return array
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request($verb, $endpoint, array $data)
    {
        $url = $endpoint;

        $response = null;

        try {
            $response = $this->httpClient->request($verb, $url, [
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
        } catch (RequestException $exception) {
            info('DSERROR1:'.$exception->getMessage());
//            throw CouldNotSendNotification::serviceRespondedWithAnHttpError($exception->getResponse());
        } catch (Exception $exception) {
            info('DSERROR2:'.$exception->getMessage());
//            throw CouldNotSendNotification::serviceCommunicationError($exception);
        }

        if (! $response) {
            return;
        }

        return json_decode($response->getBody(), true);
    }
}
