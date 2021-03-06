<?php

namespace App\Providers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\RoomType;
use App\Policies\RoomPolicy;
use App\Policies\BookingPolicy;
use App\Policies\RoomTypePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
         RoomType::class => RoomTypePolicy::class,
         Room::class => RoomPolicy::class,
         Booking::class => BookingPolicy::class,
    ];


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
