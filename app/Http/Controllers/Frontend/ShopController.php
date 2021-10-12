<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{
    
    public function shop($slug = null)
    {
        return view('frontend.shop', compact('slug'));
    }

    public function shop_tag($slug)
    {
        return view('frontend.shop_tag', compact('slug'));
    }
}
