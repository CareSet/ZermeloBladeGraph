<?php

namespace CareSet\ZermeloBladeGraph\Console;

use CareSet\Zermelo\Console\AbstractZermeloInstallCommand;

class ZermeloBladeGraphInstallCommand extends AbstractZermeloInstallCommand
{
    protected $view_path = __DIR__.'/../../views';

    protected $asset_path = __DIR__.'/../../assets';

    protected $config_file = __DIR__.'/../../config/zermelobladegraph.php';

    protected $views = [
        'zermelo/d3graph.blade.php',
        'zermelo/layouts/d3graph.blade.php',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zermelo:install_zermelobladegraph
                    {--force : Overwrite existing views by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Zermelo Blade Graph report view';
}
