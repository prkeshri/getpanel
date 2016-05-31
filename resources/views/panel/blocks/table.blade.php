<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="table_name" value="{{ $table->name }}">
@foreach($table->cols() as $col)
	<div class='row'>
		<div class='col-md-1'>{{$col->name}}</div>
		<input class='col-md-2' type='text' name='col[{{$table->name}}][{{$col->name}}][label]' value='{{$col->label}}'/>
		<input class='col-md-2' type='text' name='col[{{$table->name}}][{{$col->name}}][default_val]' value='{{$col->default_val}}'/>
		<div class='col-md-7'>
			@foreach($col->extra_config_options('col['.$table->name.']['.$col->name.']') as $option)
				<?php echo $option;?><br/>
			@endforeach
		</div>
	</div>
	<hr/>
@endforeach