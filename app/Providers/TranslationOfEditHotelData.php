<?php

namespace App\Providers;

use App\Providers\EditedHotel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TranslationOfEditHotelData
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EditedHotel $event): void
    {
        //
    }
}
