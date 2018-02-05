<?php

namespace App\Providers;

use App\FakerProviders\Image;
use App\FakerProviders\Internet;
use Blade;
use Breadcrumbs;
use Carbon\Carbon;
use DB;
use Faker\Generator as Faker;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager as FractalManager;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use Log;
use Schema;
use Storage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment() !== 'production') {
            $faker = app(Faker::class);
            $faker->addProvider(new Internet($faker));
            $faker->addProvider(new Image($faker));

            DB::listen(function ($query) {
                $sql = str_replace('?', '%s', $query->sql);
                foreach ($query->bindings as $binding) {
                    $binding = (string) $binding;
                }
                $sql = sprintf($sql, ...$query->bindings);
                Log::info('sql', [$sql, $query->time, url()->current()]);
            });
        }
        Carbon::setLocale('zh');
        Schema::defaultStringLength(191);

        Breadcrumbs::macro('pageTitle', function (string $delimiter = ' - ', string $name = null, ...$params) {
            $breadcrumb = Breadcrumbs::generate($name, ...$params);
            if ($breadcrumb->isNotEmpty()) {
                $title = $breadcrumb->slice(1)->reverse()->implode('title', $delimiter).$delimiter;
            } else {
                $title = '';
            }

            return $title.setting('site_name');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
        $this->app->singleton(FractalManager::class, function ($app) {
            return new FractalManager();
        });

        $this->app->singleton(\League\Glide\Server::class, function ($app) {
            $config = config('images');

            return ServerFactory::create([
                'response'           => new LaravelResponseFactory($this->app->make('request')),
                'source'             => Storage::disk($config['source_disk'])->getDriver(),
                'cache'              => Storage::disk($config['cache_disk'])->getDriver(),
                'source_path_prefix' => $config['source_path_prefix'],
                'cache_path_prefix'  => $config['cache_path_prefix'],
                'base_url'           => $config['base_url'],
                'presets'            => $config['presets'],
                'defaults'           => $config['default_style'],
            ]);
        });

        Blade::directive('widget', function ($expression) {
            return "<?php echo app('\App\Support\Widget\WidgetFactory')->render($expression); ?>";
        });
    }
}
