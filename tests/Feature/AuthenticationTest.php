<?php

use Tests\TestCase;

class AuthentictionTest extends TestCase
{

    public function testRequireLoginWhenNotAuthenticated()
    {
        $homeResponse = $this->get('/');
        $homeResponse->assertRedirect('/login');

        $searchResponse = $this->post('/search', array('query' => 'foo'));
        $searchResponse->assertRedirect('/login');

        $albumResponse = $this->get('/album/123');
        $albumResponse->assertRedirect('/login');

        $trackResponse = $this->get('/track/123');
        $trackResponse->assertRedirect('/login');

        $artistResponse = $this->get('/artist/123');
        $artistResponse->assertRedirect('/login');
    }
}
