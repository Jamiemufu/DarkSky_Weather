<?php

namespace App\Http\Controllers;

use App\User;
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
                    ->forecast();
        
        $forecast = $forecast->toArray();
    
        return view('page.home', compact('forecast', 'location'));
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
                    ->forecast();
        
        $forecast = $forecast->toArray();
    
        return view('page.home', compact('forecast', 'location'));
    }

    /**
     * show edit view
     *
     * @return void
     */
    public function show()
    {
        $user = Auth::user();
        $id = $user->id;
        $location = $user->preferred_location;

        return view('page.show', compact('location', 'id'));
    }

    /**
     * update resource
     *
     * @param Request $request
     * 
     * @param $id      
     */
    public function update(Request $request, $id)
    {   
        $request->validate([
            'location' => 'required|min:3'
        ]);
        
        $location = ['preferred_location' => $request->input('location')];
        User::where('id', $id)->update($location);

        return redirect('/');
    }

}
