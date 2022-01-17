<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

abstract class AbstractService
{
    protected $client;
    protected $authorization;

    public function __construct(string $baseUri, string $authorization)
    {
        $this->client = new Client(array('base_uri' => $baseUri));
        $this->authorization = $authorization;
    }

    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
        return $this;
    }

    protected function call($method, $uri, $queryParams = array(), $body = null, $isForm = false)
    {
        $params = array(
            'headers' => array(
                'Authorization' => $this->authorization
            ),
        );

        if (!empty($queryParams)) {
            $params['query'] = $queryParams;
        }

        if (!empty($body)) {
            $params[$isForm ? 'form_params' : 'body'] = $body;
        }

        try {
            $response = $this->client->request($method, $uri, $params);
            return json_decode($response->getBody(), true);
        } catch (ClientException $ce) {
            return false;
        }
    }
}
