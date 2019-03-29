<?php

namespace Ops\Services;

use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Psr\Http\Message\ResponseInterface;

class BaseClientService
{
    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @var string
     */
    protected $apiUri;

    /**
     * @var string
     */
    protected $serviceUri;

    /**
     * @var string
     */
    protected $appId;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var string
     */
    protected $ticket;

    /**
     * BaseClientService constructor.
     * @param $appId
     * @param $secretKey
     * @param $apiUri
     * @param $serviceUri
     */
    public function __construct($appId, $secretKey, $apiUri, $serviceUri)
    {
        $this->appId = $appId;
        $this->secretKey = $secretKey;

        if ($apiUri) $this->setApiUri($apiUri);
        if ($serviceUri) $this->setServiceUri($serviceUri);
    }

    /**
     * @param $apiUri
     * @return $this
     */
    public function setApiUri($apiUri)
    {
        $this->apiUri = $apiUri;

        $this->client = new Client([
            'base_uri' => $this->apiUri,
            'time_out' => 15,
            'http_errors' => false
        ]);

        return $this;
    }

    /**
     * @param $serviceUri
     * @return $this
     */
    public function setServiceUri($serviceUri)
    {
        $this->serviceUri = rtrim($serviceUri, '/');

        return $this;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    protected function getTicket()
    {
        $query = [
            'appid' => $this->appId,
            'appkey' => $this->secretKey
        ];

        $uri = '/basic/get_ticket?' . http_build_query($query);
        $response = $this->client->get($uri);

        return $this->response($response)['ticket'];
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     * @throws \Exception
     */
    protected function response(ResponseInterface $response)
    {
        try {
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents(), true);

            if ($statusCode != 200) throw new \Exception($response->getBody()->getContents());

            if ($result && (!isset($result['errcode']) || $result['errcode'] == 0)) return $result;

            throw new HttpException(500, '接口调用失败');

        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}