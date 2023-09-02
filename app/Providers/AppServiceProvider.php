<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function (QueryExecuted $query) {
            echo "new query: \n";
            echo $query->sql . "\n";
            echo print_r($query->bindings, true) . "\n";
            echo $query->time . "\n";
            echo "-------[DONE]-------\n";
        });

        Relation::enforceMorphMap([
            "private" => "App\Models\TgUser",
            "channel" => "App\Models\Channel",
            "group" => "App\Models\Group",
        ]);
    }
}
