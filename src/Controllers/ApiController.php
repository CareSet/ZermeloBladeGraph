<?php
/**
 * Created by PhpStorm.
 * User: kchapple
 * Date: 6/20/18
 * Time: 11:42 AM
 */

namespace CareSet\ZermeloBladeGraph\Controllers;


use CareSet\Zermelo\Interfaces\ControllerInterface;
use CareSet\Zermelo\Models\ZermeloReport;
use CareSet\ZermeloBladeGraph\GraphGenerator;
use CareSet\ZermeloBladeGraph\Models\CachedGraphReport;

class ApiController implements ControllerInterface
{
    public function show( ZermeloReport $report )
    {
        $cache = new CachedGraphReport( $report );
        $generatorInterface = new GraphGenerator( $cache );
        return $generatorInterface->toJson( $report );
    }

    public function prefix(): string
    {
        return api_prefix()."/".config( "zermelobladegraph.GRAPH_URI_PREFIX", "" );
    }
}
