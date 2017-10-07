<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\MaterialBrand;
use App\MaterialType;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (DB::connection() instanceof \Illuminate\Database\SQLiteConnection) {
            DB::statement(DB::raw('PRAGMA foreign_keys=1'));
        }

        \View::composer('*', function($view) {
            //$brands = \Cache::rememberForever('brands', function() {
              //  return MaterialBrand::all();
            //});
            $types = \Cache::rememberForever('types', function() {
                return MaterialType::all();
            });
            $view->with('brands', MaterialBrand::all());
            $view->with('types', $types);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
