<?php

namespace CareSet\ZermeloBladeGraph\Http\Controllers;

use CareSet\Zermelo\Http\Requests\GraphReportRequest;
use CareSet\ZermeloBladeGraph\GraphPresenter;
use Illuminate\Support\Facades\Auth;

class GraphController
{
    public function show( GraphReportRequest $request )
    {
        $report = $request->buildReport();
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
}
