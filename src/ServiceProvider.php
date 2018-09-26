<?php

namespace CareSet\ZermeloBladeGraph;

use CareSet\Zermelo\Models\AbstractZermeloProvider;
use CareSet\ZermeloBladeGraph\Console\ZermeloBladeGraphInstallCommand;
use CareSet\ZermeloBladeGraph\Controllers\ApiController;
use CareSet\ZermeloBladeGraph\Controllers\WebController;

Class ServiceProvider extends AbstractZermeloProvider
{
    protected $controllers = [

        // List your controllers here
        // this is used to build the routes in the parent class
        ApiController::class,
        WebController::class
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
            ZermeloBladeGraphInstallCommand::class
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

        $this->loadViewsFrom( resource_path( 'views/zermelo' ), 'Zermelo');
	}
}
