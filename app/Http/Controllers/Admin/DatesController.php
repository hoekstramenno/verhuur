<?php

namespace App\Http\Controllers\Admin;

use App\Date;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateDate;
use App\ApiHelpers\Filters\DatesFilter;
use App\ApiHelpers\Transformers\DatesTransformer;
use App\ApiHelpers\Paginate\Paginate as Paginate;


class DatesController extends AdminController
{

    public function __construct(DatesTransformer $tranformer)
    {
        $this->transformer = $tranformer;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DatesFilter $filter)
    {
        $dates = Date::with(['bookings.option', 'options'])->filter($filter)->paginate(10);
        return view('admin.dates.index', compact('dates'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $date = Date::published()->findOrFail($id);
//        return view('dates.show', ['date' => $date]);
    }

    /**
     * @param Date $date
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Date $date)
    {
        return view('admin.dates.edit', [
            'date' => $date
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDate $request, $id)
    {
        $date = Date::find($id);

        if (is_null($date)) {
            return $this->respondNotFound();
        }

        $request['date_to'] = date('Y-m-d H:i:s', strtotime($request['date_to']));
        $request['date_from'] = date('Y-m-d H:i:s', strtotime($request['date_from']));
        $request['published_at'] = date('Y-m-d H:i:s');

        if ( ! $request['published']) {
            $request['published_at'] = null;
        }

        unset($request['published']);

        $date->fill($request->all());
        $date->save();

        return back()->with('flash', 'Your Date is updated');;
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
