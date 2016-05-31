@extends('panel.frame')
@section('extra')
	<script>
		function append(elt,up,txt,find)
		{
			find=find|| 'input'
			up=up || 0;
			while(up++)
				elt=elt.parentElement;
			elt=elt.querySelector(find)
			elt.value+=txt;
		}
	</script>
@stop
@section('content')
	<div style='margin:auto'>
		@if(isset($message))
			<label class='label label-{{$message_type}}'>{!!$message!!}</label>
		@endif
		<h5>
			You have the following tables in your database.<br/>
			Click on each table in order to get to settings page and then generate pages specific to that table.<br/>
			Or,<br/>
			I may generate a page for every table listed as a quick task.
			<hr/>
			
			<legend>Quick tasks:</legend>
			<a href="{{action('TableController@getMiscellaneous')}}">Click here</a> for Miscellaneous settings for all tables!<br/>
			<a href="{{action('PageGenerationController@getCreateAll')}}" onclick='return confirm("Sure? This will generate a page each for a table exclusively? However you may change this later.");'>Click here </a> to generate a page for every table.
			
			<legend>Table Settings:</legend>
			<div class='row'>
				<h4 class='col-sm-2'>Tables</h4>
				<h4 class='col-sm-2'>Default Title</h4>
				<div class='col-sm-5'>Display values in combo-box(You may leave or choose to format). If you change, do click on save below in order to save the info. For more info, refer to documentation.</div>
			</div>
			<form method='post'>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				@foreach($tables as $table)
				<div>
					<div class='row'>
						<a class='col-sm-2' href='{{action('TableController@getSet',[$table->name])}}'>{{$table->name}}</a>
						<input class='col-sm-2' type='text' name='display[{{$table->name}}][title]' value='{{$table->label()}}'/>
						<input class='col-sm-2' type='text' data-list_text name='display[{{$table->name}}][list_text]' value='{{$table->display('list_text')}}'/>
					</div>
					<div class='row'>
						<div class='col-sm-12'>
							Cols:@foreach($table->cols() as $col)
								<a onclick="append(this,-3,'#{{$col->name}}#','[data-list_text]')">{{$col->name}}</a>,
								@endforeach
						</div>
					</div>
				</div>
				@endforeach
				<input type='submit' value='Save and continue'/>
			</form>
		</h5>
	</div>
@stop