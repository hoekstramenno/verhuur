<?php namespace App\Events;

use App\Booking;

use Illuminate\Queue\SerializesModels;

class BookingCancelled
{
    use SerializesModels;

    public $booking;

    /**
     * BookingCreated constructor.
     * @param Booking $booking
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }
}
