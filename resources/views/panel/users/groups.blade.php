@extends('panel.frame')
@section('content')
	<div style='margin:auto'>
		<h3>
			User Groups
		</h3>
		@if(isset($message))
			<label class='label label-{{$message_type}}'>{!!$message!!}</label>
		@endif
		<div class='row'>
			<div class='col-sm-1'><label>id</label></div>
			<div class='col-sm-4'><label>name</label></div>
			<div class='col-sm-6'><label>description</label></div>
		</div>
		@foreach ($user_groups as $user_group)
			<div class='row' style='margin-top:10px'>
				<form method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class='col-sm-1'>
						<input  class="form-control" readonly value="{{$user_group->id}}" name="user_group[id]"/>
					</div>
					<div class='col-sm-4'>
						<input class="form-control" name="user_group[name]" value='{{$user_group->name}}'/>
					</div>
					<div class='col-sm-6'>
						<input class="form-control" name="user_group[description]" value='{{$user_group->description}}'/>
					</div>
					<div class='col-sm-1'>
						<input type='submit' class='btn btn-info' value='Save'/>
					</div>
				</form>
			</div>
		@endforeach
		<hr/>
		<div class='row'>
			<form method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class='col-sm-1'>
					<input  class="form-control" readonly value="New"/>
				</div>
				<div class='col-sm-4'>
					<input class="form-control" name="user_group[name]" placeholder="short name"/>
				</div>
				<div class='col-sm-6'>
					<input class="form-control" name="user_group[description]" placeholder="long description"/>
				</div>
				<div class='col-sm-1'>
					<input type='submit' class='btn btn-info' value='Save'/>
				</div>
			</form>
		</div>
	</div>
@stop