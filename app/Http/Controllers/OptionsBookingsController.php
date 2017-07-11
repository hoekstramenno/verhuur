<?php

namespace App\Http\Controllers;

use App\Billing\PaymentFailedException;
use App\Exceptions\NoBookingsLeftException;
use App\Date;
use App\Option;
use App\Booking;
use App\Http\Requests\StoreBooking;
use App\Reservation;
use Illuminate\Http\Request;
use App\Billing\FakePaymentGateway as PaymentGateway;

class OptionsBookingsController extends Controller
{
    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  integer  $optionId
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBooking $request, $optionId)
    {
        $option = Option::findOrFail($optionId);
        $date = Date::published()->findOrFail($option->date_id);

        if ($date->bookingsRemaining() == 0) {
            return response()->json([], 422);
        }

        try {
            // Is it still available // Create booking
            if ($date->isStillAvailable()) {
                $booking = Booking::forOption($option);
                return response()->json($booking->toArray(), 201);
            }

        } catch(NoBookingsLeftException $e) {
            return response()->json([], 422);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
