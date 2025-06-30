<?php

namespace App\Providers;

use Dompdf\Dompdf;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind('dompdf', function ($app) {
            $options = $app->make('dompdf.options');
            $dompdf = new Dompdf($options);
    
            // Custom public path pointing to your real public_html
            $customPublicPath = realpath(base_path('../public_html'));
    
            if ($customPublicPath === false) {
                throw new \RuntimeException('Cannot resolve custom public path');
            }
    
            $dompdf->setBasePath($customPublicPath);
    
            return $dompdf;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
