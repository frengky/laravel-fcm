<?php

namespace Frengky\Fcm;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use Kreait\Firebase;
use Kreait\Firebase\Factory as FirebaseFactory;
use Kreait\Firebase\ServiceAccount;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(
            realpath(__DIR__ . '/../database/migrations')
        );
        $this->publishes([
            realpath(__DIR__.'/../config/fcm.php') => config_path('fcm.php')
        ], 'config');
    }
    
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            realpath(__DIR__.'/../config/fcm.php'), 'fcm'
        );

        $this->app->singleton(Firebase::class, function($app) {
            $credential = $app['config']['fcm.firebase_credentials'];
            if (! empty($credential)) {
                if (! file_exists(realpath($credential))) {
                    throw new \RuntimeException('Missing firebase credentials (service account) JSON key file.');
                }
                $serviceAccount = ServiceAccount::fromJsonFile($credential);
            } else {
                $serviceAccount = ServiceAccount::discover();
            }
            return (new FirebaseFactory)->withServiceAccount($serviceAccount)->create();
        });

        $this->app->singleton('fcm', function($app) {
            return $app->makeWith(FcmManager::class, [
                'android' => $app['config']['fcm.android'],
                'apns' => $app['config']['fcm.apns']
            ]);
        });

    }
}