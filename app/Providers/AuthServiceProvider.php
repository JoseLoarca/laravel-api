<?php

namespace App\Providers;

use App\Buyer;
use App\Policies\BuyerPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Buyer::class => BuyerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes(null, ['prefix' => 'api/oauth']);
        Passport::tokensExpireIn(Carbon::now()->addMinutes(120));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();

        Passport::tokensCan([
            'purchase-product' => 'Crear transacciones para comprar productos',
            'manage-products'  => 'Crear, ver, actualizar y eliminar productos',
            'manage-account'   => 'Obtener la informacion de la cuenta, nombre, email, estado. Modificar datos.',
            'read-general'     => 'Obtener informacion en general.'
        ]);
    }
}
