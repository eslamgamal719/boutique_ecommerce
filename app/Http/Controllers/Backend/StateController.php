<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_states', ['only' => ['index']]);
        $this->middleware('permission:create_state', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_state', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_state', ['only' => ['destroy']]);
        $this->middleware('permission:display_state', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::withCount('cities')

        ->when(request()->keyword != null, function($q) {
            $q->search(request()->keyword);
        })
        ->when(request()->status != null, function($q) {
            $q->whereStatus(true);
        })
        ->orderBy(request()->sort_by ?? 'id', request()->order_by ?? 'desc')

        ->paginate(request()->limit_by ?? 10);

        return view('backend.states.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::whereStatus(true)->get(['id', 'name']);
        return view('backend.states.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateRequest $request)
    {
        State::create($request->validated());

        return redirect()->route('admin.states.index')->with([
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
    public function show(State $state)
    {
        return view('backend.states.show', compact('state'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        $countries = Country::whereStatus(true)->get(['id', 'name']);
        return view('backend.states.edit', compact('state', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StateRequest $request, State $state)
    {
        $state->update($request->validated());

        return redirect()->route('admin.states.index')->with([
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
    public function destroy(State $state)
    {
        $state->delete();

        return redirect()->route('admin.states.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }


    public function get_states(Request $request)
    {
        $states = State::whereStatus(true)->whereCountryId($request->country_id)->get(['id', 'name'])->toArray();
        return response()->json($states);
    }
}
