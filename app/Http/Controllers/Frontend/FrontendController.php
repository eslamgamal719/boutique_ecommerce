<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    
    public function index() 
    {
        $categories = Category::whereStatus(1)->whereParentId(null)->get();
        return view('frontend.index', compact('categories'));
    }


}
