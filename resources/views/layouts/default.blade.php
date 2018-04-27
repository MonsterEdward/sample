<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Simple APP') -- laravel beginner</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
	{{-- <header class="navbar navbar-fixed-top navbar-inverse">
		<div class="col-md-offset-1 col-md-10">
			<a href="/" id="logo">Sample APP</a>
			<nav>
				<ul class="nav navbar-nav navbar-right">
					<li><a herf="/help">HELP</a></li>
					<li><a href="#">LOGIN</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<div class="container">
		@yield('content')
	</div> --}}
	@include('layouts._header')
	<div class="container">
		<div class="col-md-offset-1 col-md-10">
			@yield('content')
			@include('layouts._footer')
		</div>
	</div>
</body>
</html>