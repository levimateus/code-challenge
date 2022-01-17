<?php

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Tests\TestCase;

abstract class AbstractServiceTest extends TestCase
{

    protected function prepareClient($baseUri, $mock, array &$container)
    {
        $history = Middleware::history($container);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $client = new Client(array(
            'handler' => $handlerStack,
            'base_uri' => $baseUri
        ));

        return $client;
    }
}
