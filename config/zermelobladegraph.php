<?php

return [

    /**
     * Path where the Report display.
     * This is used in implementations of ControllerInterface@show method
     * Note: the API routes are auto generated with this same URI path with the api-prefixed to the url
     * /ZermeloGraph/(ReportName) (see config/zermelo.php for api prefix setting)
     */
    'GRAPH_URI_PREFIX'=>env("GRAPH_URI_PREFIX","ZermeloGraph"),

    /**
     * The template the controller will use to render the report
     * This is used in WebController implementation of ControllerInterface@show method
     */
    'GRAPH_VIEW_TEMPLATE'=>env("GRAPH_VIEW_TEMPLATE","Zermelo::layouts.d3graph"),
];
