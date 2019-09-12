<?php

namespace CareSet\ZermeloBladeGraph;

use CareSet\Zermelo\Models\AbstractZermeloProvider;
use CareSet\ZermeloBladeGraph\Console\MakeGraphReportCommand;
use CareSet\ZermeloBladeGraph\Console\ZermeloBladeGraphInstallCommand;
use Illuminate\Support\Facades\Route;

Class ServiceProvider extends AbstractZermeloProvider
{
    protected $controllers = [

        // List your controllers here
        // this is used to build the routes in the parent class
        // no longer used, shoudl be removed
    ];

	protected function onBeforeRegister()
	{
        /*
         * Register our zermelo view make command which:
         *  - Copies views
         *  - Exports configuration
         *  - Exports Assets
         */
        $this->commands([
            ZermeloBladeGraphInstallCommand::class,
            MakeGraphReportCommand::class
        ]);

	    /*
	     * Merge with main config so parameters are accessable.
	     * Try to load config from the app's config directory first,
	     * then load from the package.
	     */
	    if ( file_exists( config_path( 'zermelobladegraph.php' ) ) ) {

            $this->mergeConfigFrom(
                config_path( 'zermelobladegraph.php' ), 'zermelobladegraph'
            );
        } else {
            $this->mergeConfigFrom(
                __DIR__.'/../config/zermelobladegraph.php', 'zermelobladegraph'
            );
        }

        $this->registerWebRoutes();

        $this->loadViewsFrom( resource_path( 'views/zermelo' ), 'Zermelo');
	}


    /**
     * Load the given routes file if routes are not already cached.
     *
     * @param  string  $path
     * @return void
     */
    protected function loadRoutesFrom($path)
    {
        if (! $this->app->routesAreCached()) {
            require $path;
        }
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerWebRoutes()
    {
        $configuration = $this->routeConfiguration();
        Route::group($configuration, function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Get the Nova route group configuration array.
     *
     * @return array
     */
    protected function routeConfiguration()
    {
        $middleware = config('zermelobladegraph.MIDDLEWARE',[ 'web' ]);
        $middlewareString = implode(",",$middleware);

        return [
            'namespace' => 'CareSet\ZermeloBladeGraph\Http\Controllers',
            //  'domain' => config('zermelo.domain', null),
            'as' => 'zermelo.graph.',
            'prefix' => config( 'zermelobladegraph.GRAPH_URI_PREFIX' ),
            'middleware' => $middlewareString,
        ];
    }
}
