@extends('layouts.default')
@section('title', 'LOGIN')

@section('content')
<div class="col-md-offset-2 col-md-8">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h5>LOGIN</h5>
		</div>
		<div class="panel-body">
			@include('shared._errors')

			<form method="POST" action="{{ route('login') }}">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="email">
						Email:	
					</label>
					<input type="text" name="email" class="form-control" value="{{ old('email') }}">
					<lable for="password">Password (<a href="{{ route('password.request') }}">Forget your password</a>) :</lable>
					<input type="password" name="password" class="form-control" value="{{ old('password') }}">

					<div class="checkbox">
						<label><input type="checkbox" name="remember">Remember Me</label>
					</div>

					<button type="submit" class="btn btn-primary">LOGIN</button>
				</div>
			</form>
			<hr>
			<p>No account yet?<a href="{{ route('signup') }}">Go to signup</a></p>
		</div>
	</div>
</div>
@stop
