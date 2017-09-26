<?php namespace App\Http\Controllers\Api;

use App\Date;
use App\Http\Requests\UpdateDate;
use Illuminate\Http\Request;
use App\ApiHelpers\Filters\DatesFilter;
use App\ApiHelpers\Date\Helper as DateHelper;
//use App\Http\Requests\Api\CreateArticle;
//use App\Http\Requests\Api\UpdateArticle;
use App\ApiHelpers\Transformers\DatesTransformer;
use App\ApiHelpers\Paginate\Paginate as Paginate;
use App\Http\Requests\StoreDate;
use App\Http\Requests\MultiStoreDate;
use Carbon\Carbon;


class DatesController extends ApiController
{

    protected $dateHelper;

    /**
     * ArticleController constructor.
     *
     * @param DatesTransformer $transformer
     */
    public function __construct(DatesTransformer $transformer, DateHelper $dateHelper )
    {
        $this->transformer = $transformer;
        $this->dateHelper = $dateHelper;
    }

    /**
     * Get all the dates.
     *
     * @param DatesFilter $filter
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(DatesFilter $filter)
    {
        $dates = new Paginate(Date::future()->with('options')->filter($filter));
        $dates = new Paginate(Date::with('options')->filter($filter));

        return $this->respondWithPagination($dates);
    }

    /**
     * Create new date
     *
     * @param StoreDate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDate $request)
    {
        $userId = auth()->user()->id;

        $date = Date::create([
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'price' => $request->input('price'),
            'published_at' => $request->input('published_at'),
            'admin_id' => $userId,
            'status' => ($request->input('status') ?: 1)
        ]);

        return $this->respondWithTransformer($date);
    }

    /**
     * Give a datarange and create bulk dates
     *
     * @param MultiStoreDate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function range(MultiStoreDate $request)
    {
        $dateFrom = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('date_from'));
        $dateTo = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('date_to'));

        if ($request->input('only_weekend') == true) {
            return $this->createWeekends($request, $dateFrom, $dateTo);
        }

        return $this->createWeeks($request, $dateFrom, $dateTo);
    }

    /**
     * Get the date with id of $id
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $date = Date::published()->future()->with('options')->find($id);
        $date = Date::published()->with('options')->find($id);

        if (is_null($date)) {
            return $this->respondNoContent();
        }

        return $this->respondWithTransformer($date);
    }

    /**
     * Update Date with Id of $id
     *
     * @param UpdateDate $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDate $request, $id)
    {
        $date = Date::published()->find($id);

        if (is_null($date)) {
            return $this->respondNotFound();
        }

        $date->fill($request->all());
        $date->save();

        return $this->respondWithTransformer($date);
    }

    /**
     * Destroy Date with Id of $id
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $date = Date::findOrFail($id);
        $date->delete();
        return $this->respondSuccess();
    }

    /**
     * Filter all weekends in the range and create dates for them
     *
     * @param MultiStoreDate $request
     * @param $dateFrom
     * @param $dateTo
     * @return \Illuminate\Http\JsonResponse|static
     */
    public function createWeekends(MultiStoreDate $request, $dateFrom, $dateTo)
    {
        $weekends = $this->dateHelper->getOnlyTheWeekends($dateFrom, $dateTo);

        foreach ($weekends as $weekend) {
            if ( ! $this->dateHelper->checkInRange($dateFrom, $dateTo, Carbon::parse($weekend['end']))) {
                return $this->respondError(__('Not a complete weekend: Please at ' . $weekend['end'] . ' to the range'), 422);
            }
        }

        Date::createRange($request, $weekends);

        return $this->respondSuccess();
    }

    /**
     * Filter all weekends in the range and create dates for them
     *
     * @param MultiStoreDate $request
     * @param $dateFrom
     * @param $dateTo
     * @return \Illuminate\Http\JsonResponse|static
     */
    public function createWeeks(MultiStoreDate $request, $dateFrom, $dateTo)
    {
        // Chunk het op in weken
        $weeks = $this->dateHelper->splitInWeeks($dateFrom, $dateTo);

        foreach ($weeks as $week) {
            if ( ! $this->dateHelper->checkInRange($dateFrom, $dateTo, Carbon::parse($week['end'])->subDay())) {
                return $this->respondError(__('Not a complete week: Please select a complete week in the range'), 422);
            }
        }

        Date::createRange($request, $weeks);

        return $this->respondSuccess();
    }


}
