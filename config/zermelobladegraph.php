<?php

return [

    /**
     * Path where the Graph display.
     * This path should be inside the web route and points to ZermeloGraphController@GraphDisplay
     * Note: the API routes are auto generated with this same URI path with the api-prefixed to the url
     * /ZermeloGraph/(ReportName)
     */
    'GRAPH_URI_PREFIX'=>env("GRAPH_URI_PREFIX","ZermeloGraph"),

    'GRAPH_VIEW_TEMPLATE'=>env("GRAPH_VIEW_TEMPLATE","Zermelo::layouts.d3graph"),
];