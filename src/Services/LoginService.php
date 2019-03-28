<?php

namespace Ops\Services;

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
        $response = $this->client->get($uri);

        return $this->response($response);
    }
}