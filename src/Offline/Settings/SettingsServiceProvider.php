<?php namespace Offline\Settings;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php', 'settings'
        );
        $this->publishes([
            __DIR__ . '/../../config/config.php', config_path('settings.php')
        ], 'config');
        $this->publishes([
            __DIR__ . '/../../migrations/' => base_path('/database/migrations')
        ], 'migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['settings'] = $this->app->share(function ($app) {

            $config = $app->config->get('settings', [
                'cache_file' => storage_path('settings.json'),
                'db_table'   => 'settings'
            ]);

            return new Settings($app['db'], new Cache($config['cache_file']), $config);
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array ('settings');
    }

}