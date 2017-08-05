<?php namespace App\Http\Controllers\Api;

use App\Date;
use App\Http\Requests\UpdateDate;
use Illuminate\Http\Request;
use App\ApiHelpers\Filters\DatesFilter;
//use App\Http\Requests\Api\CreateArticle;
//use App\Http\Requests\Api\UpdateArticle;
use App\ApiHelpers\Transformers\DatesTransformer;
use App\ApiHelpers\Paginate\Paginate as Paginate;
use App\Http\Requests\StoreDate;

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
     * @param StoreDate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDate $request)
    {
        $user = auth()->user();
        //$userId = $user->id;

        // TEST ///
        $userId = 1;

        if ( ! is_null($user)) {
            $userId = $user->id;
        }
        // END TEST//

        $date = Date::create([
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'price' => $request->input('price'),
            'published_at' => $request->input('published_at'),
            'admin_id' => $userId,
            'status' => 1
        ]);

        return $this->respondWithTransformer($date);
    }

    /**
     * Get the article given by its slug.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $date = Date::published()->future()->findOrFail($id);
        return $this->respondWithTransformer($date);
    }

    /**
     * @param UpdateDate $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDate $request, $id)
    {
        $date = Date::published()->findOrFail($id);
        $date->fill($request->all());
        $date->save();

        return $this->respondWithTransformer($date);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $date = Date::findOrFail($id);
        $date->delete();
        return $this->respondSuccess();
    }
}
