<?php namespace App\Http\Controllers\Reunie;

use App\ReuniePerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApiHelpers\Filters\Reunie\PersonFilter;

class PersonsController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(PersonFilter $filters)
    {
        $persons = ReuniePerson::get()->paginate(20);

        if (request()->wantsJson()) {
            return $persons;
        }
        return view('reunie.persons.index', compact('persons'));
    }

    /**
     * Create new date
     *
     * @param StoreReuniePerson $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return view('reunie.material.create');
    }

    /**
     * @param ReuniePerson $person
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(ReuniePerson $person)
    {
        return view('reunie.persons.show', [
            'person' => $person
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'age' => 'required'
        ]);

        ReuniePerson::create([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'age' => $request->input('age'),
            'created_by' => 1
        ]);

        return redirect('reunie/persons/create')->with('flash', 'A Person is added');
    }

}