<?php

use App\SpotifyAccountService;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class SpotifyAccountServiceTest extends AbstractServiceTest
{

    public function testGetTokenJson()
    {
        $accessToken = 'theAccessToken';
        $expiresIn = 3600;
        $refreshToken = 'theRefreshToken';
        $baseUri = 'http://localhost';

        $authorization = 'Basic ' . base64_encode('apiKey:secret');
        $redirectUri = 'http://localhost';
        $code = 'mockCode';

        $responseBody = array(
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'scope' => 'scope',
            'expires_in' => $expiresIn,
            'refresh_token' => $refreshToken
        );

        $mock = new MockHandler(array(
            new Response(200, array(), json_encode($responseBody))
        ));

        $container = array();
        $client = $this->prepareClient($baseUri, $mock, $container);

        $spotifyAccountService = new SpotifyAccountService(
            'default',
            $authorization
        );

        $spotifyAccountService->setClient($client);

        $beginningTime = new DateTimeImmutable();
        $token = $spotifyAccountService->requestAccessToken($code, $redirectUri);
        $finishingTime = new DateTimeImmutable();

        $this->assertCount(1, $container);

        $this->assertEquals($accessToken, $token['access_token'] ?? false);
        $this->assertEquals($refreshToken, $token['refresh_token'] ?? false);
        $this->assertEquals($expiresIn, $token['expires_in'] ?? false);
        $this->assertGreaterThanOrEqual($beginningTime, $token['issued_at']);
        $this->assertLessThanOrEqual($finishingTime, $token['issued_at']);

        foreach ($container as $transaction) {
            $formParameters = $transaction['request']->getBody()->getContents();
            $formParameters = explode('&', urldecode($formParameters));

            $this->assertEquals(
                $authorization,
                $transaction['request']->getHeader('Authorization')[0] ?? false
            );

            $this->assertContains("code={$code}", $formParameters);
            $this->assertContains("grant_type=authorization_code", $formParameters);
            $this->assertContains(htmlentities("redirect_uri={$redirectUri}"), $formParameters);
        }
    }

    public function testErrorWhileGeneratingToken()
    {
        $baseUri = 'http://localhost';

        $mock = new MockHandler(array(
            new Response(400)
        ));

        $container = array();
        $client = $this->prepareClient($baseUri, $mock, $container);

        $authorization = 'Basic ' . base64_encode('apiKey:secret');
        $redirectUri = 'http://localhost';
        $code = 'mockCode';

        $spotifyAccountService = new SpotifyAccountService(
            'default',
            $authorization
        );

        $spotifyAccountService->setClient($client);

        $token = $spotifyAccountService->requestAccessToken($code, $redirectUri);
        $this->assertFalse($token);
    }
}
