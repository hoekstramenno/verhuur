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
    public function create($dateId)
    {
        //$date = Date::published()->available()->findOrFail($dateId);
        //return view('options.create', ['date' => $date]);
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
