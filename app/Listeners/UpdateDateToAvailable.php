<?php

namespace App\Listeners;
use App\Date;
use App\Events\BookingCancelled;

class UpdateDateToAvailable
{
    /**
     * updateDateStatus constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BookingCreated $event
     * @return void
     */
    public function handle(BookingCancelled $event)
    {
        $dateId = $event->booking->date_id;
        $date = Date::findOrFail($dateId);

        $date->status = Date::STATUS_AVAILABLE;
        $date->save();
    }
}