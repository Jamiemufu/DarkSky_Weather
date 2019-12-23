<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DmitryIvanov\DarkSkyApi\DarkSkyApi;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $forecast = (new DarkSkyApi(env('DARK_SKY_KEY')))
                    ->location(Auth::user()->lat, Auth::user()->lng)
                    ->forecast();

        return view('home');
    }
}
