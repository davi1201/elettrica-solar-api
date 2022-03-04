<?php

namespace App\Providers;

use App\Infrastructure\Services\SolarCalculatorService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use NumberFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('number-format', function () {
            $locale = App::getLocale();
            return new NumberFormatter($locale, NumberFormatter::DECIMAL);
        });

        $this->app->bind(SolarCalculatorService::class, function () {
            $config = config('subsolar.panels');

            return new SolarCalculatorService(
                collect($config)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_MONETARY, 'pt_BR');
        Schema::defaultStringLength(191);
        Blade::directive('convert', function ($money) {
            return "<?php echo number_format($money, 2, ',', '.'); ?>";
        });
    }
}
