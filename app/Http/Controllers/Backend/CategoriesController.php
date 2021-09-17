<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CategoriesRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show_categories', ['only' => ['index']]);
        $this->middleware('permission:create_category', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_category', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_category', ['only' => ['destroy']]);
        $this->middleware('permission:display_category', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        $categories = Category::withCount('products')

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

        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $main_categories = Category::whereNull('parent_id')->select('id', 'name')->get();
        return view('backend.categories.create', compact('main_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesRequest $request)
    {
        $input['name'] = $request->name;
        $input['status'] = $request->status;
        $input['parent_id'] = $request->parent_id;

        if($image = $request->file('cover')) {
            $file_name = Str::slug($request->name) . "." . $image->getClientOriginalExtension();
            $path = public_path("assets/categories/" . $file_name);
            \Image::make($image->getRealPath())->resize(500, null, function($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $input['cover'] = $file_name;
        }

        Category::create($input);

        return redirect()->route('admin.categories.index')->with([
            'message' => 'Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('backend.categories.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $main_categories = Category::whereNull('parent_id')->get(['id', 'name']);
        return view('backend.categories.edit', compact('main_categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesRequest $request, Category $category)
    {
        $input['name'] = $request->name;
        $input['slug'] = null;
        $input['status'] = $request->status;
        $input['parent_id'] = $request->parent_id;

        if($image = $request->file('cover')) {
            if($category->cover != null && File::exists('assets/categories/' . $category->cover)) {
                unlink('assets/categories/' . $category->cover);
            }
            $file_name = Str::slug($request->name) . "." . $image->getClientOriginalExtension();
            $path = public_path("assets/categories/" . $file_name);
            \Image::make($image->getRealPath())->resize(500, null, function($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $input['cover'] = $file_name;
        }

        $category->update($input);

        return redirect()->route('admin.categories.index')->with([
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
    public function destroy(Category $category)
    {
        if(File::exists("assets/categories/" . $category->cover)) {
            unlink("assets/categories/" . $category->cover);
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with([
            'message' => 'Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }


    public function remove_image(Request $request)
    {
        //dd($request->all());
        $category = Category::findOrFail($request->category_id);
        if(File::exists("assets/categories/" . $category->cover)) {
            unlink("assets/categories/" . $category->cover);
            $category->cover = null;
            $category->save();
        }
        return true;
    }
}
