<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if(!request()->is('admin/*')) {
            view()->composer('*', function($view) {

                $categories_main = Category::whereParentId(null)->whereStatus(true)->get();
                $categories_sub = Category::where('parent_id', '!=', null)->whereStatus(true)->get();

                if(!Cache::has('shop_categories_main')) {
                    Cache::forever('shop_categories_main', $categories_main);
                }
                $shop_categories_main = Cache::get('shop_categories_main');

                if(!Cache::has('shop_categories_sub')) {
                    Cache::forever('shop_categories_sub', $categories_sub);
                }
                $shop_categories_sub = Cache::get('shop_categories_sub');

                $tags = Tag::whereStatus(true)->get();

                if(!Cache::has('shop_tags_menu')) {
                    Cache::forever('shop_tags_menu', $tags);
                }
                $shop_tags_menu = Cache::get('shop_tags_menu');

                $view->with([
                    'shop_categories_main' => $shop_categories_main,
                    'shop_categories_sub' => $shop_categories_sub,
                    'shop_tags_menu' => $shop_tags_menu
                ]);
            });
        }
    }
}
