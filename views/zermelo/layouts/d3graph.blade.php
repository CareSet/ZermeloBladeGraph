<html>
<head>

    <title>{{ $presenter->getReport()->getReportName() }}</title>

    <link rel="stylesheet" type="text/css" href="/vendor/CareSet/bootstrap/css/bootstrap.min.css"/>
    <link href="//use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/vendor/CareSet/css/d3.custom.css"/>

</head>
<body>

@include('Zermelo::d3graph')

</body>
</html>
