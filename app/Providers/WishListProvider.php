<?php

namespace App\Providers;

use App\DatabaseStorage;
use Illuminate\Support\ServiceProvider;
use Darryldecode\Cart\Cart;

class WishListProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton('wishlist', function($app)
        {
            $storage = new DatabaseStorage();
            $events = $app['events'];
            $instanceName = 'wishList';
            $session_key = '88uuiioo99888';
            return new Cart(
                $storage,
                $events,
                $instanceName,
                $session_key,
                config('shopping_cart')
            );
        });
    }
}
