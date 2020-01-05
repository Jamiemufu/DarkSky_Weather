<?php

namespace App\Mail;

//need to get darkSky API results here

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklySummary extends Mailable
{
    use Queueable, SerializesModels;
    public $forecast;
    public $location;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($forecast, $location, $name)
    {
        $this->forecast = $forecast;
        $this->location = $location;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.summary');
    }
}
