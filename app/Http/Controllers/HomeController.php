<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use DmitryIvanov\DarkSkyApi\DarkSkyApi;
use Geocoder;
use Illuminate\View\View;
use Throwable;

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
     * @return Renderable
     */
    public function index()
    {
        return view('page.home');
    }

    /**
     * preferred forecast json response for axios
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function preferredForecast()
    {
        $user = Auth::user();
        $lat = $user->lat;
        $lng = $user->lng;
        $location = $user->preferred_location;

        $forecast = (new DarkSkyApi(env('DARK_SKY_KEY')))
                    ->location($lat, $lng)
                    ->forecast();

        $forecast = $forecast->daily()->toArray();

        return response()->json([$forecast, $location]);
    }

    /**
     * search for weather
     *
     * @param mixed $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function search(Request $request)
    {
        $location = $request->location;
        $coords = Geocoder::getCoordinatesForAddress($location);

        $forecast = (new DarkSkyApi(env('DARK_SKY_KEY')))
                    ->location($coords['lat'], $coords['lng'])
                    ->forecast();

        $forecast = $forecast->daily()->toArray();

        return response()->json([$forecast, $location]);
    }

    /**
     * show edit preferred location view
     *
     * @return Factory|View
     */
    public function show()
    {
        $user = Auth::user();
        $id = $user->id;
        $location = $user->preferred_location;

        return view('page.show', compact('location', 'id'));
    }

    /**
     * update preferred location
     *
     * @param Request $request
     *
     * @param $id
     * @return RedirectResponse|Redirector
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
