<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\View;
// use Illuminate\Support\Facades\Schema;
// use App\Models\Category;
// use App\Models\CategoryParent;
// use App\Models\Collection;
// use App\Models\Settings;
// use App\Models\Cart;
// use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // view::composer('*', function($view) {
        //     $ip = $_SERVER['REMOTE_ADDR'];

        //     // categories
        //     $categoryExists = Schema::hasTable('categories');
        //     if ($categoryExists) {
        //         // $parentCategories = CategoryParent::orderBy('position', 'asc')->orderBy('id', 'desc')->where('status', 1)->get();
        //         // dd($parentCategories);
        //         $categories = Category::with('parentCatDetails')->orderBy('parent', 'asc')->orderBy('position', 'desc')->where('status', 1)->get();

        //         $categoryNavList = [];

        //         foreach ($categories as $catKey => $catValue) {
                    
        //         }
        //     }
            
        //     // cart count
        //     $cartExists = Schema::hasTable('carts');
        //     if ($cartExists) {
        //         if (Auth::check()) {
        //             $cartCount = Cart::where('user_id', Auth::user()->id)->get();

        //             $totalCartProducts = 0;
        //             foreach($cartCount as $cartKey => $cartVal) {
        //                 $totalCartProducts += $cartVal->qty;
        //             }
        //         } else {
        //             $totalCartProducts = 0;
        //         }

        //     }


        //     view()->share('categories', $categories);
        //     view()->share('categoryNavList', $categoryNavList);            
        //     view()->share('cartCount', $totalCartProducts);
        // });
    }
}
