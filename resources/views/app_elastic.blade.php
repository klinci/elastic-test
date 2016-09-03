<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Elastic Search</title>
		
		<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
		<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	</head>
	<body class="fixed layout-top-nav">
		<div class="wrapper">		
			<div class="content-wrapper">
				<div class="container">	
					<section class="content">
						@yield('main-content')
					</section>
				</div>
			</div>
		</div>
		
		<!-- Scripts -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
		
		@yield('javascript_per_page')
	</body>
</html>