<?php namespace App\Http\Controllers\Magazijn;

use App\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApiHelpers\Filters\MaterialFilter;

class MaterialsController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(MaterialFilter $filters)
    {
        $materials = Material::paginate(15);

        if (request()->wantsJson()) {
            return $materials;
        }
        return view('magazijn.material.index', compact('materials'));
    }

    /**
     * Create new date
     *
     * @param StoreMaterial $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return view('magazijn.material.create');
    }

    /**
     * @param Material $material
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Material $material)
    {
        return view('magazijn.material.show', [
            'material' => $material,
            'remarks' => $material->remarks()->paginate(20)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'qty' => 'required',
            'size' => 'required',
            //'type_id' => 'required|exists:material_type,id',
            'brand_id' => 'required|exists:material_brand,id'
        ]);

        $thread = Material::create([
            'name' => $request->input('name'),
            'size' => $request->input('size'),
            'qty' => $request->input('qty'),
            'created_by' => 1,
            'type_id' => $request->input('qty'),
            'brand_id' => $request->input('brand_id'),
        ]);

        return redirect('magazijn/materiaal/create')->with('flash', 'Your material is added');
    }

}