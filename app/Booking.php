<?php

namespace App;
use App\Events\BookingCancelled;
use App\Events\BookingCreated;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    //protected $with = ['option'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
        'created' => BookingCreated::class,
        'cancelled' => BookingCancelled::class
    ];

    /**
     * Creating a Booking for an option
     *
     * @param $option
     * @return mixed
     */
    public static function forOption($option)
    {
        return $option->bookings()->create([
            'date_id' => $option->date_id
        ]);
    }


    /**
     * An Booking belong to a Option
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option()
    {
        return $this->belongsTo('App\Option');
    }

    /**
     * An Booking Belongs to a Date
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function date()
    {
        return $this->belongsTo('App\Date');
    }

    /**
     * Get price attribute from date
     * @return mixed
     */
    public function getPriceAttribute()
    {
        return $this->date->price;
    }

    /**
     * Cancel a booking
     */
    public function cancel()
    {
        event(new BookingCancelled($this));
        $this->update([
            'option_id' => null,
            'date_id' => null
        ]);

    }
}
