<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show_reviews', ['only' => ['index']]);
        $this->middleware('permission:update_review', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_review', ['only' => ['destroy']]);
        $this->middleware('permission:display_review', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        $reviews = Review::with('product', 'user')

        //keyword
        ->when(request()->keyword != null, function($query) {
            $query->search(request()->keyword);
        })

        //status
        ->when(request()->status != null, function($query) {
            $query->whereStatus(request()->status);
        })
        
        //sort_by, order_by
        ->orderBy(request()->sort_by ?? 'id', request()->order_by ?? 'desc')
        
        //limit_by
        ->paginate(request()->limit_by ?? 10);

        return view('backend.reviews.index', compact('reviews'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return view('backend.reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        return view('backend.reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequest $request, Review $review)
    {
        $review->update($request->validated());

        return redirect()->route('admin.reviews.index')->with([
            'message' => 'Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with([
            'message' => 'Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }

}
