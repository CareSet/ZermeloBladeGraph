<?php

namespace CareSet\ZermeloBladeGraph\Http\Controllers;

use CareSet\Zermelo\Http\Controllers\AbstractWebController;
use CareSet\Zermelo\Http\Requests\GraphReportRequest;
use CareSet\Zermelo\Models\Presenter;
use CareSet\ZermeloBladeGraph\GraphPresenter;

class GraphController extends AbstractWebController
{

    public  function getViewTemplate()
    {
        return config("zermelobladegraph.GRAPH_VIEW_TEMPLATE", "" );
    }

    public  function getReportApiPrefix()
    {
        return config('zermelobladegraph.GRAPH_URI_PREFIX');
    }

    /**
     * @param $report
     * @return Presenter
     *
     * Build the presenter, push the graph_uri onto the view
     */
    public function buildPresenter($report)
    {
        $presenter = new Presenter($report);
        $presenter->pushViewVariable('graph_uri', $this->getGraphUri($report));

        return $presenter;
    }

    public function getGraphUri($report)
    {
        $parameterString = implode("/", $report->getMergedParameters() );
        $graph_api_uri = "/{$this->getApiPrefix()}/{$this->getGraphPath()}/{$report->getClassName()}/{$parameterString}";
        $graph_api_uri = rtrim($graph_api_uri,'/'); //for when there is no parameterString
        return $graph_api_uri;
    }
}
