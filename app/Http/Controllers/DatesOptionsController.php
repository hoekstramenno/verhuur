<?php

namespace App\Http\Controllers;

use App\Billing\PaymentFailedException;
use App\Exceptions\NoBookingsLeftException;
use App\Date;
use App\Http\Requests\StoreOption;
use App\Option;
use App\Booking;
use App\Reservation;
use Illuminate\Http\Request;
use App\Billing\FakePaymentGateway as PaymentGateway;

class DatesOptionsController extends Controller
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
        return view('dates.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  integer  $dateId
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOption $request, $dateId)
    {
        $date = Date::published()->available()->findOrFail($dateId);

        if ($date->bookingsRemaining() == 0) {
            return response()->json([], 422);
        }

        try {

            // Is it still available
            if ($date->isStillAvailable()) {
                $reservation = $date->createReservation($date, request('pax'), request('email'));

                // Create option and charge
                $option = $reservation->toOption($this->paymentGateway, request('payment_token'));

                return response()->json($option->toArray(), 201);
            }

        } catch(PaymentFailedException $e) {
            return response()->json([], 422);
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
