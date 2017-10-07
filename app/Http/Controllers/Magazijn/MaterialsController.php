<?php namespace App\Http\Controllers\Api\Magazijn;

use App\Date;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\UpdateDate;
use Illuminate\Http\Request;
use App\ApiHelpers\Filters\MaterialFilter;
use App\ApiHelpers\Material\Helper as Material;
//use App\Http\Requests\Api\CreateArticle;
//use App\Http\Requests\Api\UpdateArticle;
use App\ApiHelpers\Transformers\MaterialsTransformer;
use App\ApiHelpers\Paginate\Paginate as Paginate;
use App\Http\Requests\StoreMaterial;
use App\Http\Requests\MultiStoreDate;
use Carbon\Carbon;

class MaterialsController extends ApiController
{

    /**
     * @var MaterialsTransformer
     */
    protected $transformer;

    /**
     * @var Material
     */
    protected $materialHelper;

    public function __construct(MaterialsTransformer $transformer, Material $materialHelper )
    {
        $this->transformer = $transformer;
        $this->materialHelper = $materialHelper;
    }

    /**
     * Get all the dates.
     *
     * @param MaterialFilter $filter
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(MaterialFilter $filter)
    {
        $material = new Paginate(Material::with([
            'brands',
            'remarks'
        ])->filter($filter));

        return $this->respondWithPagination($material);
    }

    /**
     * Create new date
     *
     * @param StoreMaterial $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMaterial $request)
    {
        $userId = auth()->user()->id;

        $date = Date::create([
            'name' => $request->input('name'),
            'size' => $request->input('size'),
            'qty' => $request->input('qty'),
            'created_by' => $userId,
            'type_id' => $request->input('qty'),
            'brand_id' => $request->input('brand_id'),
        ]);

        return $this->respondWithTransformer($date);
    }

}