@extends('panel.frame')
@section('extra')
	<script>
	</script>
@stop
@section('content')
	<div style='margin:auto'>
		<h3>
			Table: {{$table->name}}
			<small>(Default settings for the table)</small>
		</h3>
			<hr/>
			<div class='row'>
			<h4 class='col-md-1'>Column</h4>
			<div class='col-md-2'>Label</div>
			<div class='col-md-2'>Default Value</div>
			<div class='col-md-7'>Miscelleneous Settings</div>
			</div>
			<form method='post'>
				@include('panel.blocks.table',['mode'=>'table'])
				<input type='submit' value='Save'/>
				<a href='{{action('PageGenerationController@getCreate',[$table->name])}}'>Create Page</a>
			</form>
	</div>
@stop