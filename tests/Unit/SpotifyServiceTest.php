<?php

use App\SpotifyService;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class SpotifyServiceTest extends AbstractServiceTest
{
    public function testSearchTerm()
    {
        $baseUri = 'http://localhost';
        $query = 'searchTerm';

        $responseBody = array(
            'artists' => array(),
            'albums' => array(),
            'tracks' => array(),
        );

        $mock = new MockHandler(array(
            new Response(200, array(), json_encode($responseBody))
        ));

        $container = array();
        $client = $this->prepareClient($baseUri, $mock, $container);

        $authorization = 'Bearer ' . base64_encode('{"apiKey":"secret"}');

        $spotifyAccountService = new SpotifyService(
            'default',
            $authorization
        );

        $spotifyAccountService->setClient($client);
        $response = $spotifyAccountService->search($query);

        $this->assertCount(1, $container);
        $this->assertArrayHasKey('artists', $response);
        $this->assertArrayHasKey('albums', $response);
        $this->assertArrayHasKey('tracks', $response);

        foreach ($container as $transaction) {
            $this->assertEquals(
                $authorization,
                $transaction['request']->getHeader('Authorization')[0] ?? false
            );

            $queryParameters = $transaction['request']->getUri()->getQuery();
            $queryParameters = explode('&', urldecode($queryParameters));

            $this->assertContains("q={$query}", $queryParameters);
            $this->assertContains("type=track,artist,album", $queryParameters);
        }
    }

    public function testErrorWhileSearchingTerm()
    {
        $baseUri = 'http://localhost';
        $query = 'searchTerm';

        $mock = new MockHandler(array(
            new Response(401)
        ));

        $container = array();
        $client = $this->prepareClient($baseUri, $mock, $container);

        $authorization = 'Bearer ' . base64_encode('{"apiKey":"secret"}');

        $spotifyAccountService = new SpotifyService(
            'default',
            $authorization
        );

        $spotifyAccountService->setClient($client);
        $response = $spotifyAccountService->search($query);

        $this->assertFalse($response);
    }

    public function testGetSpotifyEntity()
    {
        $baseUri = 'http://localhost';
        $id = '123456';
        $endpoint = 'tracks';

        $responseBody = array(
            'name' => "string",
        );

        $mock = new MockHandler(array(
            new Response(200, array(), json_encode($responseBody))
        ));

        $container = array();
        $client = $this->prepareClient($baseUri, $mock, $container);

        $authorization = 'Bearer ' . base64_encode('{"apiKey":"secret"}');

        $spotifyAccountService = new SpotifyService(
            'default',
            $authorization
        );

        $spotifyAccountService->setClient($client);
        $response = $spotifyAccountService->get($endpoint, $id);

        $this->assertCount(1, $container);
        $this->assertArrayHasKey('name', $response);

        foreach ($container as $transaction) {
            $this->assertEquals(
                $authorization,
                $transaction['request']->getHeader('Authorization')[0] ?? false
            );

            $queryParameters = $transaction['request']->getUri();
            $this->assertContains(
                "{$baseUri}/v1/{$endpoint}/$id",
                (string) $queryParameters
            );
        }
    }

    public function testErrorWhileGettingEntity()
    {
        $baseUri = 'http://localhost';
        $id = '123456';
        $endpoint = 'tracks';

        $mock = new MockHandler(array(
            new Response(401)
        ));

        $container = array();
        $client = $this->prepareClient($baseUri, $mock, $container);

        $authorization = 'Bearer ' . base64_encode('{"apiKey":"secret"}');

        $spotifyAccountService = new SpotifyService(
            'default',
            $authorization
        );

        $spotifyAccountService->setClient($client);
        $response = $spotifyAccountService->get($endpoint, $id);

        $this->assertFalse($response);
    }
}
