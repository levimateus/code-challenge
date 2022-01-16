<?php

namespace App;

class SpotifyService extends AbstractService
{
    public function search(string $query)
    {
        if (empty($query)) {
            return false;
        }

        $params = array(
            'q' => $query,
            'type' => 'track,artist,album'
        );

        return $this->call('GET', 'v1/search', $params);
    }

    public function get($endpoint, $id)
    {
        return $this->call('GET', "/v1/{$endpoint}/{$id}");
    }
}
