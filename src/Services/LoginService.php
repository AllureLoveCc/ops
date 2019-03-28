<?php

namespace Ops\Services;

use GuzzleHttp\Client;

trait LoginService
{

    /**
     * @param $token
     * @return mixed
     * @throws \Exception
     */
    public function loginVerify($token)
    {
        $query = [
            'ticket' => $this->getTicket(),
            'token' => $token
        ];

        $uri = '/sso/verify?' . http_build_query($query);
        /** @var Client $client */
        $response = $this->client->get($uri);

        return $this->response($response);
    }
}