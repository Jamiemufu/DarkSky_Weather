<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DmitryIvanov\DarkSkyApi\DarkSkyApi;
use Geocoder;
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
        $user = Auth::user();
        $lat = $user->lat;
        $lng = $user->lng;
        $location = $user->preferred_location;

        $forecast = (new DarkSkyApi(env('DARK_SKY_KEY')))
                    ->location($lat, $lng)
                    ->forecast(['currently', 'daily']);
        
        $current = $forecast->currently()->toArray();
        $daily = $forecast->daily()->toArray();

        // dd($daily);
        // dd($today);

        return view('page.home', compact('current', 'daily', 'location'));
    }

    /**
     * search for weather
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function search(Request $request)
    {
        $location = $request->input('search');
        $coords = Geocoder::getCoordinatesForAddress($location);

        $forecast = (new DarkSkyApi(env('DARK_SKY_KEY')))
                    ->location($coords['lat'], $coords['lng'])
                    ->forecast(['currently', 'daily']);
        
        $current = $forecast->currently()->toArray();
        $daily = $forecast->daily()->toArray();

        return view('page.home', compact('current', 'daily', 'location'));
    }
}
