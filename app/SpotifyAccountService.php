<?php

namespace App;

use DateTimeImmutable;

class SpotifyAccountService extends AbstractService
{
    public function requestAccessToken(string $code, $redirectUri)
    {
        if (empty($code)) {
            return false;
        }

        $params = array(
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri
        );

        $token = $this->call('POST', '/api/token', array(), $params, true);

        $currentTime = new DateTimeImmutable();
        $token['issued_at'] = $currentTime;

        return $token;
    }
}
