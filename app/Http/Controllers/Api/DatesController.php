<?php namespace App\Http\Controllers\Api;

use App\Date;
use Illuminate\Http\Request;
use App\ApiHelpers\Filters\DatesFilter;
use App\Http\Requests\Api\CreateArticle;
use App\Http\Requests\Api\UpdateArticle;
use App\ApiHelpers\Transformers\DatesTransformer;
use App\ApiHelpers\Paginate\Paginate as Paginate;

class DatesController extends ApiController
{
    /**
     * ArticleController constructor.
     *
     * @param DatesTransformer $transformer
     */
    public function __construct(DatesTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function index()
    //{
        //return Date::published()->future()->get();
    //}

    /**
     * Get all the dates.
     *
     * @param DatesFilter $filter
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(DatesFilter $filter)
    {
        $dates = new Paginate(Date::published()->future()->filter($filter));
        return $this->respondWithPagination($dates);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Get the article given by its slug.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $date = Date::published()->findOrFail($id);
        return $this->respondWithTransformer($date);
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $date = Date::published()->findOrFail($id);
        $date->delete();
        return $this->respondSuccess();
    }
}
