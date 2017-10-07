<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $guarded = [];


    /**
     * Create option for date
     * @param $date
     * @param $email
     * @param int $pax
     * @param $amount
     * @return App/Option
     */
    public static function forDate($date, $email, $pax = 1, $amount)
    {
        if ($date->isStillAvailable()) {
            return self::create([
                'date_id' => $date->id,
                'email' => $email,
                'pax' => $pax,
                'amount' => $amount
            ]);
        }
    }


    /**
     * A Option has many Bookings
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * An Option belongs to Date
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function date()
    {
        return $this->belongsTo(Date::class);
    }

    /**
     * Cancel a option if somethings wrong
     *
     * @param $optionId
     * @return void
     */
    public function cancel($optionId)
    {
        $option = $this->where('id', $optionId)->first();
        $option->delete();
    }

    /**
     * Return public variable
     *
     * @return array
     */
    public function toArray()
    {
        return [
          'email' => $this->email,
          'pax' => $this->pax,
          'amount' => $this->date->price * $this->pax
        ];
    }

    /**
     * Check if this option have a booking
     */
    public function isBooked()
    {
        $count = $this->bookings()->count();
        if ($count > 0) {
            return true;
        }
        return false;
    }
}
