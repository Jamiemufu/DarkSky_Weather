<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\User;
use DmitryIvanov\DarkSkyApi\DarkSkyApi;
use App\Mail\WeeklySummary;

class sendWeeklyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly summary of a users preferred location every Sunday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get daily results and users send to mailable
     *
     * @return void
     */
    public function handle()
    {
        $users = User::where('consent', 1)->get();

        foreach ($users as $user)
        {
            $name = $user->name;
            $location = $user->preferred_location;
            $lat = $user->lat;
            $lng = $user->lng;

            $forecast = (new DarkSkyApi(env('DARK_SKY_KEY')))
                    ->location($lat, $lng)
                    ->forecast('daily');
        
            $forecast = $forecast->daily()->toArray();

            Mail::to($user->email)->send(new WeeklySummary($forecast, $location, $name));
        }
    }
}
