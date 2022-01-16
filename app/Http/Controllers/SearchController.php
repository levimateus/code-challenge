<?php

namespace App\Http\Controllers;

use App\SpotifyService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    const SPOTIFY_BASE_URI = 'https://api.spotify.com';

    protected $spotifyService;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('index');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $results = $this->getSpotifyService()->search($query);
        return view('search-result', ['searchTerm' => $query])->with('results', $results);
    }

    public function getAlbum($id)
    {
        $album = $this->getSpotifyService()->get('albums', $id);
        return view('album-details')->with('album', $album);
    }

    public function getArtist($id)
    {
        $artist = $this->getSpotifyService()->get('artists', $id);
        return view('artist-details')->with('artist', $artist);
    }

    public function getTrack($id)
    {
        $track = $this->getSpotifyService()->get('tracks', $id);
        return view('track-details')->with('track', $track);
    }

    protected function getSpotifyService()
    {
        if (empty($this->spotifyService)) {
            $this->spotifyService = new SpotifyService(
                self::SPOTIFY_BASE_URI,
                'Bearer ' . session('accessToken')['access_token']
            );
        }

        return $this->spotifyService;
    }
}
