@extends('layouts.default')
@section('title', 'Sign Up')

@section('content')
{{--<h1>SIGN UP</h1>--}}
<div class="col-md-offset-2 col-md-8">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5>SIGN UP</h5>
		</div>
		<div class="panel-body">
			@include('shared._errors')
			<form method="POST" action="{{ route('users.store') }}">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="name">Name: </label>
					<input type="text" name="name" class="form-control" value="{{ old('name') }}">
				</div>

				<div class="form-group">
					<lable for="email">Email: </lable>
					<input type="text" name="email" class="form-control" value="{{ old('email') }}">
				</div>

				<div class="form-group">
					<label for="password">Password: </label>
					<input type="password" name="password" class="form-control" value="{{ old('password') }}">
				</div>

				<div class="form-group">
					<label for="password_confirmation">Password confirmation: </label>
					<input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
				</div>

				<button type="submit" class="btn btn-primary">SIGN UP</button>
			</form>
		</div>
	</div>
</div>
@stop
