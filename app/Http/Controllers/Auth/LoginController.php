<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\SpotifyAuthenticator;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
        $this->clientId = env('SPOTIFY_CLIENT_ID');
        $this->clientSecret = env('SPOTIFY_CLIENT_SECRET');
        $this->redirectUri = env('SPOTIFY_REDIRECT_URL');
    }

    public function showLoginPage()
    {
        return view('login');
    }

    public function login()
    {
        $scope = 'user-read-private user-read-email';

        $parameters = array(
            'client_id' => $this->clientId,
            'scope' => $scope,
            'response_type' => 'code',
            'redirect_uri' => $this->redirectUri,
        );

        return redirect()->away('https://accounts.spotify.com/authorize?' . http_build_query($parameters));
    }

    public function attemptLogin(Request $request)
    {
        if (!empty($request->get('error'))) {
            return redirect('/login');
        }

        $spotifyAuthenticator = new SpotifyAuthenticator($this->clientId, $this->clientSecret, $this->redirectUri);
        $token = $spotifyAuthenticator->requestAccessToken($request->get('code'));

        session(array('accessToken' => $token));

        return redirect('/');
    }
}
