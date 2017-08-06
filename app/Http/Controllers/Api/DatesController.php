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
        $dates = new Paginate(Date::published()->future()->filter($filter));
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
    public function multistore(MultiStoreDate $request)
    {
        $user = auth()->user();
        //$userId = $user->id;

        // TEST ///
        $userId = 1;

        if ( ! is_null($user)) {
            $userId = $user->id;
        }
        // END TEST//

        $dateFrom = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('date_from'));
        $dateTo = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('date_to'));

        if ($request->input('only_weekend') == true) {
            return $this->createWeekendDatesInRange($request, $dateFrom, $dateTo, $userId);
        }
        return $this->createWeekDatesInRange($request, $dateFrom, $dateTo, $userId);
    }

    /**
     * Get the date with id of $id
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
     * Update Date with Id of $id
     *
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
     * @param $userId
     * @return \Illuminate\Http\JsonResponse|static
     */
    public function createWeekendDatesInRange(MultiStoreDate $request, $dateFrom, $dateTo, $userId)
    {
        $weekends = $this->dateHelper->getOnlyTheWeekends($dateFrom, $dateTo);

        foreach ($weekends as $weekend) {
            if ( ! $this->dateHelper->checkInRange($dateFrom, $dateTo, Carbon::parse($weekend['end']))) {
                return $this->respondError(__('Not a complete weekend: Please at ' . $weekend['end'] . ' to the range'), 422);
            }
        }

        $dates = Date::createNewDatesFromRange($request, $userId, $weekends);

        return $this->respondWithTransformer($dates);
    }

    /**
     * Filter all weekends in the range and create dates for them
     *
     * @param MultiStoreDate $request
     * @param $dateFrom
     * @param $dateTo
     * @param $userId
     * @return \Illuminate\Http\JsonResponse|static
     */
    public function createWeekDatesInRange(MultiStoreDate $request, $dateFrom, $dateTo, $userId)
    {
        // Chunk het op in weken
        $weeks = $this->dateHelper->splitInWeeks($dateFrom, $dateTo);

        foreach ($weeks as $week) {
            if ( ! $this->dateHelper->checkInRange($dateFrom, $dateTo, Carbon::parse($week['end'])->subDay())) {
                return $this->respondError(__('Not a complete week: Please select a complete week in the range'), 422);
            }
        }

        $dates = Date::createNewDatesFromRange($request, $userId, $weeks);

        return $this->respondWithTransformer($dates);
    }


}
