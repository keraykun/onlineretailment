<?php

namespace App\Providers;

use App\Models\Products;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        App\Models\Cart::class=>App\Policies\CartPolicy::class,
        App\Models\Products::class=>App\Policies\ProductsPolicy::class,
        App\Models\productSold::class=>App\Policies\ProductSoldPolicy::class,
        App\Models\productReports::class=>App\Policies\ProductReportsPolicy::class,
        App\Models\replyReports::class=>App\Policies\replyReportsPolicy::class,
    ];


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('user-create', function (User $user) {
            return $user->id === Auth::user()->id;
        });
    }
}
