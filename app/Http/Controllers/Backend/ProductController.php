<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductRequest;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
 
    public function __construct()
    {
      
        $this->middleware('permission:show_products', ['only' => ['index']]);
        $this->middleware('permission:create_product', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_product', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_product', ['only' => ['destroy']]);
        $this->middleware('permission:display_product', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        $products = Product::with(['tags', 'category', 'media'])

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

        return view('backend.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::whereStatus(true)->get(['id', 'name']);
        $tags = Tag::whereStatus(true)->get(['id', 'name']);
        return view('backend.products.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $input['name']        = $request->name;
        $input['description'] = $request->description;
        $input['price']       = $request->price;
        $input['quantity']    = $request->quantity;
        $input['category_id'] = $request->category_id;
        $input['featured']    = $request->featured;
        $input['status']      = $request->status;

        $product = Product::create($input);
        $product->tags()->attach($request->tags);

        if($request->images && count($request->images) > 0) {
            $i = 1;
            foreach($request->images as $image) {
                $file_name = $product->slug . '_' . $i . time() . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/products/' . $file_name);

                \Image::make($image->getRealPath())->resize(500, null, function($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $product->media()->create([
                     'file_name'    => $file_name,
                     'file_size'    => $file_size,
                     'file_type'    => $file_type,
                     'file_status'  => true,
                     'file_sort'    => $i,
                ]);
                $i++;
            }
        }
        return redirect()->route('admin.products.index')->with([
            'message'    => 'Created successfully',
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
        return view('backend.products.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::whereStatus(true)->get(['id', 'name']);
        $tags = Tag::whereStatus(true)->get(['id', 'name']);
        
        return view('backend.products.edit', compact('categories', 'tags', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $input['name']        = $request->name;
        $input['description'] = $request->description;
        $input['price']       = $request->price;
        $input['quantity']    = $request->quantity;
        $input['category_id'] = $request->category_id;
        $input['featured']    = $request->featured;
        $input['status']      = $request->status;

        $product->update($input);
        $product->tags()->sync($request->tags); //to add new elements only

        if($request->images && count($request->images) > 0) {

            $i = $product->media()->count() + 1;

            foreach($request->images as $image) {
                $file_name = $product->slug . '_' . $i . time() . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/products/' . $file_name);

                \Image::make($image->getRealPath())->resize(500, null, function($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $product->media()->create([
                     'file_name'    => $file_name,
                     'file_size'    => $file_size,
                     'file_type'    => $file_type,
                     'file_status'  => true,
                     'file_sort'    => $i,
                ]);
                $i++;
            }
        }
        return redirect()->route('admin.products.index')->with([
            'message'    => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->media()->count() > 0) {
            foreach($product->media as $media) {
                if(File::exists('assets/products/' . $media->file_name)) {
                    unlink('assets/products/' . $media->file_name);
                }
                $media->delete();
            }
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with([
            'message'    => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }

    public function remove_image(Request $request)
    {
        //dd($request->all());
        $product = Product::findOrFail($request->product_id);
        $image = $product->media()->whereId($request->image_id)->first();

        if(File::exists('assets/products/' . $image->file_name)) {
            unlink('assets/products/' . $image->file_name);
        }
        $image->delete();
        return true;
    }
}
