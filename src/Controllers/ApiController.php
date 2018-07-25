<?php
/**
 * Created by PhpStorm.
 * User: kchapple
 * Date: 6/20/18
 * Time: 11:42 AM
 */

namespace CareSet\ZermeloBladeGraph\Controllers;


use CareSet\Zermelo\Interfaces\ControllerInterface;
use CareSet\Zermelo\Models\DatabaseCache;
use CareSet\Zermelo\Models\ZermeloReport;
use CareSet\ZermeloBladeGraph\GraphGenerator;

class ApiController implements ControllerInterface
{
    public function show( ZermeloReport $report )
    {

        $cacheInterface = new DatabaseCache();
        $generatorInterface = new GraphGenerator( $cacheInterface );
        return $generatorInterface->toJson( $report );
    }

    public function prefix(): string
    {
        return api_prefix()."/".config( "zermelobladegraph.GRAPH_URI_PREFIX", "" );
    }
}
