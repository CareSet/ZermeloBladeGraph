<?php

namespace CareSet\ZermeloBladeGraph\Controllers;

use CareSet\Zermelo\Interfaces\ControllerInterface;
use CareSet\Zermelo\Models\ZermeloReport;
use CareSet\ZermeloBladeGraph\Models\GraphPresenter;
use DB;
use Illuminate\Support\Facades\Auth;

class WebController implements ControllerInterface
{
    public function show( ZermeloReport $report )
    {
        $presenter = new GraphPresenter( $report );
        $presenter->setApiPrefix( api_prefix() );
        $presenter->setGraphPath( config('zermelobladegraph.GRAPH_URI_PREFIX') );

        $user = Auth::guard()->user();
        if ( $user ) {
            $view_data['token'] = $user->last_token;
        }

        $view = $presenter->getGraphView();
        if (!$view) {
            $view = config("zermelobladegraph.GRAPH_VIEW_TEMPLATE", "" );
        }

        return view( $view, [ 'presenter' => $presenter ] );
    }

    public function prefix(): string
    {
        return config( "zermelobladegraph.GRAPH_URI_PREFIX", "" );
    }
}
