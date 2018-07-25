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
//        $api_uri = "/" . trim(config("zermelo.URI_API_PREFIX"),"/") ."/". trim(config("zermelo.URI_GRAPH_PATH"), "/ ") . "/";

        $presenter->setApiPrefix( api_prefix() );
        $presenter->setGraphPath( config('zermelobladegraph.GRAPH_URI_PREFIX') );

//        $view_data = [];
//        $view_data['Report_Name'] = $report->getReportName();
//        $view_data['Report_Description'] = $report->getReportDescription();
//        $view_data['api_url'] = $api_uri;
//        $view_data['input_bolt'] = $report->GetBoltId();
//        $view_data['request_form_input'] = $request_form_input;
//        $view_data['token'] = '';
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
