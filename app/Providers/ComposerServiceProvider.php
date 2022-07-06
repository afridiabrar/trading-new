<?php

namespace App\Providers;

use App\Model\SocialMedia;
use App\Model\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
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
        \View::composer('*', function($view)
        {
            $wishLists = [];
            if (auth('customer')->check()) {
                $userWishLists = Wishlist::where('customer_id', auth('customer')->id())->get();
                foreach ($userWishLists as $key => $data) {
                    $wishLists[] = $data->product_id;
                }
            }

            $view->with('socialMedia', SocialMedia::where('active_status', 1)->get());
            $view->with('wishLists', $wishLists);
        });
    }
}
