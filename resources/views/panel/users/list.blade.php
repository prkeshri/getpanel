@extends('panel.frame')
@section('content')
	<div style='margin:auto'>
		<h3>
			Users
		</h3>
		@if(isset($message))
			<label class='label label-{{$message_type}}'>{!!$message!!}</label>
		@endif
		<div class='row'>
			<div class='col-sm-1'><label></label></div>
			<div class='col-sm-4'><label>name</label></div>
			<div class='col-sm-6'><label>email</label></div>
		</div>
		@foreach ($users as $user)
			<div class='row' style='margin-top:10px'>
				<form method="post" action="{{action('Auth\UserController@postDelete')}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class='col-sm-1'>
						<input type="hidden" value="{{$user->id}}" name="user[id]"/>
					</div>
					<div class='col-sm-4'>
						<input class="form-control" readonly name="user[name]" value='{{$user->name}}'/>
					</div>
					<div class='col-sm-4'>
						<input class="form-control" readonly name="user[email]" value='{{$user->email}}'/>
					</div>
					<div class='col-sm-1'>
						<a href="{{action('Auth\\UserController@getEdit',[$user->id])}}" class='btn btn-info'>Edit</a>
					</div>
					<div class='col-sm-1'>
						<input type='submit' class='btn btn-danger' value='Delete' onclick="return confirm('Sure? This cannot be undone!')"/>
					</div>
				</form>
			</div>
		@endforeach
		<hr/>
		<a href="{{action('Auth\\AuthController@showRegistrationForm')}}">New</a>
	</div>
@stop