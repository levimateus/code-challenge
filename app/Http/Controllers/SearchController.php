<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
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

        return view('search-result', ['searchTerm' => $query]);
    }
}
