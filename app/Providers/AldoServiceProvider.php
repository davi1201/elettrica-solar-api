<?php

namespace App\Providers;

use App\Infrastructure\Aldo\AldoParameters;
use App\Infrastructure\Aldo\Client\AldoClient;
use App\Infrastructure\Aldo\Client\FixedXmlResponseClient;
use App\Infrastructure\Aldo\Client\XmlFetcher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AldoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(XmlFetcher::class, AldoClient::class);

        $this->app->bind(AldoParameters::class, function () {
            $validator = Validator::make(config('subsolar.import'), [
                'endpoint' => 'required|url',
                'username' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                throw new \InvalidArgumentException('Invalid Webservice configuration found: ' . $validator->errors()->first());
            }

            return new AldoParameters(
                config('subsolar.import.endpoint'),
                config('subsolar.import.username'),
                config('subsolar.import.password')
            );
        });

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
