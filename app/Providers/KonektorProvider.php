<?php

namespace Kopika\Providers;

use Illuminate\Support\ServiceProvider;

class KonektorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      require_once app_path('Helpers/MainPack.php');
      require_once app_path('Helpers/IPFSKonektor.php');
      require_once app_path('Helpers/ArtikelHelper.php');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
