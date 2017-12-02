<?php

/**
 * Created by PhpStorm.
 * User: lee
 * Date: 30/11/2017
 * Time: 4:48 PM
 */
namespace Jcsofts\LaravelLinkmobility;

use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use Jcsofts\LaravelLinkmobility\Lib\Linkmobility;

class LinkmobilityServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $dist = __DIR__.'/../config/linkmobility.php';
        if (function_exists('config_path')) {
            // Publishes config File.
            $this->publishes([
                $dist => config_path('linkmobility.php'),
            ]);
        }
        $this->mergeConfigFrom($dist, 'linkmobility');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Linkmobility::class, function ($app) {
            return $this->createInstance($app['config']);
        });
    }

    public function provides()
    {
        return [Linkmobility::class];
    }

    protected function createInstance(Repository $config)
    {
        // Check for messente config file.
        if (! $this->hasConfigSection()) {
            $this->raiseRunTimeException('Missing linkmobility configuration section.');
        }
        // Check for username.
        if ($this->configHasNo('username')) {
            $this->raiseRunTimeException('Missing linkmobility configuration: "username".');
        }
        // check the password
        if ($this->configHasNo('password')) {
            $this->raiseRunTimeException('Missing linkmobility configuration: "password".');
        }

        $debug=$config->get('linkmobility.debug',true);

        return new Linkmobility($config->get('linkmobility.username'), $config->get('linkmobility.password'),$debug,$config->get('linkmobility.options'));

    }

    /**
     * Checks if has global linkmobility configuration section.
     *
     * @return bool
     */
    protected function hasConfigSection()
    {
        return $this->app->make(Repository::class)
            ->has('linkmobility');
    }

    /**
     * Checks if linkmobility config does not
     * have a value for the given key.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function configHasNo($key)
    {
        return ! $this->configHas($key);
    }

    /**
     * Checks if linkmobility config has value for the
     * given key.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function configHas($key)
    {
        /** @var Config $config */
        $config = $this->app->make(Repository::class);
        // Check for linkmobility config file.
        if (! $config->has('linkmobility')) {
            return false;
        }
        return
            $config->has('linkmobility.'.$key) &&
            ! is_null($config->get('linkmobility.'.$key)) &&
            ! empty($config->get('linkmobility.'.$key));
    }

    /**
     * Raises Runtime exception.
     *
     * @param string $message
     *
     * @throws \RuntimeException
     */
    protected function raiseRunTimeException($message)
    {
        throw new \RuntimeException($message);
    }
}