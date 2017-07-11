<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Status;
use Carbon\Carbon;

class Date extends Model
{
    const STATUS_AVAILABLE    = 1;
    const STATUS_BOOKED = 2;
    const STATUS_NOT_AVAILABLE  = 3;

    /**
     * Whitelist all
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Carbon entities
     * @var array
     */
    protected $dates = [
        'date_from',
        'date_to'
    ];

    /**
     * Book limit for this date
     * Default is one
     *
     * @var int
     */
    public $bookLimit = 1;


    public function listStatus()
    {
        return [
            self::STATUS_AVAILABLE    => 'Beschikbaar',
            self::STATUS_BOOKED => 'Geboekt',
            self::STATUS_NOT_AVAILABLE  => 'Niet beschikbaar'
        ];
    }


    /**
     * Scope for published_at
     *
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    /**
     * Scope for status
     *
     * @param $query
     * @return mixed
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', $this::STATUS_AVAILABLE);
    }

    /**
     * Scope for status
     *
     * @param $query
     * @return mixed
     */
    public function scopeFuture($query)
    {
        return $query->where('date_from', '>=', Carbon::yesterday());
    }


    /**
     * Formatted date from attribute
     *
     * @return mixed
     */
    public function getFormattedFromDateAttribute()
    {
        return $this->date_from->format('F j, Y');
    }

    /**
     * Formatted date to attribute
     *
     * @return mixed
     */
    public function getFormattedToDateAttribute()
    {
        return $this->date_to->format('F j, Y');
    }

    /**
     * Formatted Start time attribute
     *
     * @return mixed
     */
    public function getFormattedStartTimeAttribute()
    {
        return $this->date_from->format('g:i a');
    }

    /**
     * Formatted End time attribute
     *
     * @return mixed
     */
    public function getFormattedEndTimeAttribute()
    {
        return $this->date_to->format('g:i a');
    }

    /**
     * Get formatted price attribute
     *
     * @return string
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price / 100, 2, ',', '.');
    }

    /**
     * Date has many options
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Date has many bookings
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if email has options for this date
     *
     * @param $email
     * @return mixed
     */
    public function hasOptionsFor($email)
    {
        return $this->options()->where('email', $email)->first();
    }

    /**
     * Check if the option is still available
     * Check if the booklimit is not violated
     *
     * @return \App\Exceptions\NoBookingsLeftException
     */
    public function isStillAvailable()
    {
        if ($this->bookingsRemaining() <= 0) {
            throw new \App\Exceptions\NoBookingsLeftException;
        }

        return true;
    }

    /**
     * Create reservation of a date and a request
     *
     * @param $date
     * @param $pax
     * @param $email
     * @return Reservation
     */
    public function createReservation($date, $pax, $email)
    {
        return new Reservation($date, $pax, $email);
    }

    /**
     * Change the booking limit for this date
     *
     * @param integer $quantity
     * @return void
     */
    public function addBookLimit($quantity)
    {
        $this->bookLimit = $quantity;
    }

    /**
     * Get the remaining bookings positions for this date
     *
     * @return int
     */
    public function bookingsRemaining()
    {
        return $this->bookLimit - $this->bookings()->count();
    }

    /**
     * Return the total of made options for this date
     *
     * @return int
     */
    public function totalOptions()
    {
        return $this->options()->count();
    }

    /**
     * Get label status of this date
     * @return string
     */
    public function getStatusLabel()
    {
        $list = $this->listStatus();

        // little validation here just in case someone mess things
        // up and there's a ghost status saved in DB
        return isset($list[$this->status])
            ? $list[$this->status]
            : $this->status;
    }

}
