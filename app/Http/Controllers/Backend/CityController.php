<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CityRequest;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_cities', ['only' => ['index']]);
        $this->middleware('permission:create_city', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_city', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_city', ['only' => ['destroy']]);
        $this->middleware('permission:display_city', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::query()

        ->when(request()->keyword != null, function($q) {
            $q->search(request()->keyword);
        })
        ->when(request()->status != null, function($q) {
            $q->whereStatus(true);
        })
        ->orderBy(request()->sort_by ?? 'id', request()->order_by ?? 'desc')

        ->paginate(request()->limit_by ?? 10);

        return view('backend.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::get(['id', 'name']);
        return view('backend.cities.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        City::create($request->validated());

        return redirect()->route('admin.cities.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        return view('backend.cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $states = State::get(['id', 'name']);
        return view('backend.cities.edit', compact('city', 'states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, City $city)
    {
        $city->update($request->validated());

        return redirect()->route('admin.cities.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('admin.cities.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }

    public function get_cities(Request $request)
    {
        $cities = City::whereStatus(true)->whereStateId($request->state_id)->get(['id', 'name'])->toArray();
        return response()->json($cities);
    }
}
