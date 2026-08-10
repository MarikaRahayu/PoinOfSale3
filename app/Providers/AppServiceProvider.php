<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider AS ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Models\User;
use App\Policies\DashboardPolicy;
use App\Models\Produk;
use App\policies\ProdukPolicy;

class AppServiceProvider extends ServiceProvider
{
   protected $policities = [
    User::class => DashboardPolicy::class,
    Produk::class => ProdukPolicy::class
   ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Carbon::setLocale('id');
        $this->registerPolicies();
    }
}
