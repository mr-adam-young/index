<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// --- logging
use DB;
use Log;
// ---

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
        // https://codebriefly.com/how-to-log-all-sql-queries-in-laravel/
        // Add in boot function
        DB::listen(function($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });
    }
}
