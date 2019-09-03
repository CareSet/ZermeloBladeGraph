<!doctype html>
<html lang="en">
<head>

    	<title>{{ $presenter->getReport()->getReportName() }}</title>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta name="description" content="Cube is a map of the healthcare system">
    	<meta name="author" content="CareSet Team">

	

    	<!-- standard styles -->
	<link type="text/css" rel="stylesheet" href="/css/bootstrap.4.3.1.min.css">
    	<link type="text/css" rel="stylesheet" href="/fontawesome/css/all.css">

    	<link type="text/css" rel="stylesheet" href="/css/colors.css">
    	<link type="text/css" rel="stylesheet" href="/css/taxonomyChooser.css">
	        <!-- custom css -->
        <link type="text/css" rel="stylesheet" href="/css/colors.css"/>
        <link type="text/css" rel="stylesheet" href="/css/noselect.css"/>
        <link type="text/css" rel="stylesheet" href="/css/print.css"/>
        <link type="text/css" rel="stylesheet" href="/css/floating.feedback.css"/>

    	<!-- standard javascript -->
    	<script type="text/javascript" language="javascript" src="/js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap.4.3.1.min.js"></script>

  <script type='text/javascript' language='javascript' src='/js/d3.3.5.17.min.js'></script>
	<script type="text/javascript" src="/js/saveSvgAsPng.js"></script>


	<!-- custom javascript -->
	<script type="text/javascript" src="/js/util.js"></script>
	<script type="text/javascript" src="/js/careset_api.js"></script>
  	<script type="text/javascript" src="/js/html2canvas.js"></script>
  
	<!-- font awesome js -->
	<script type="text/javascript" language="javascript" src="/fontawesome/js/all.js"></script>


<!-- end dust_html.tpl -->

    	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    	<!--[if lt IE 9]>
      		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    	<![endif]-->


 <script>
  $(document).ready(function()
       {

			

		//a function that only calls the url in data-url, and does nothing else.
		$('body').on('click','.press_url_element',function() {
//			alert('been clicked');
     			url = $(this).attr('data-url');
     			$.get(url);
			$(this).addClass("btn-success");
		});

       }
  );

  </script>

</head>
<body>

@include('Zermelo::d3graph')

</body>
</html>
