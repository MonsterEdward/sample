<header class="navbar navbar-fixed-top navbar-inverse">
	<div class="container">
		<a href="/" id="logo">Sample APP</a>
		<nav>
			<ul class="nav navbar-nav navbar-right">
				@if (Auth::check())
				<li><a href="#">Users's list</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						{{ Auth::user()->name }}
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('users.show', Auth::user()->id) }}">Users' Center</a></li>
						<li><a href="#">Edit Information</a></li>
						<li class="divider"></li>
						<li>
							<a id="logout" href="#">
								<form action="{{ route('logout') }}" method="POST">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}
									<button class="btn btn-block btn-danger" type="submit" name="button">LOGOUT</button>
								</form>
							</a>
						</li>
					</ul>
				</li>
				@else
					<li><a href="{{ route('help') }}">HELP</a></li>
					<li><a href="{{ route('login') }}">LOGIN</a></li>
				@endif
			</ul>
		</nav>
	</div>
</header>