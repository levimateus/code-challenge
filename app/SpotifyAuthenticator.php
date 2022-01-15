<?php

namespace App;

use DateTimeImmutable;
use GuzzleHttp\Exception\ClientException;

class SpotifyAuthenticator
{

    const BASE_URI = 'https://accounts.spotify.com';

    private $clientId = '';
    private $clientSecret = '';
    private $redirectUri = '';

    public function __construct($clientId, $clientSecret, $redirectUri)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
    }

    public function requestAccessToken(string $code, $grantType = 'authorization_code')
    {
        if (empty($code)) {
            return false;
        }

        try {
            $params = array(
                'grant_type' => $grantType,
                'code' => $code,
                'redirect_uri' => $this->redirectUri
            );

            $client = new \GuzzleHttp\Client(array(
                'base_uri' => self::BASE_URI
            ));

            $response = $client->request('POST', '/api/token', array(
                'auth' => array($this->clientId, $this->clientSecret),
                'form_params' => $params,
            ));

            $currentTime = new DateTimeImmutable();
            $token = json_decode($response->getBody(), true);
            $token['issued_at'] = $currentTime;

            return $token;
        } catch (ClientException $ce) {
            return false;
        }
    }
}
