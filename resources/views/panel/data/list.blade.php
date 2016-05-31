@extends('panel.frame')
@section('extra')
<style type="text/css">
	th,td {
	    border: solid 1px;
	    padding: 2px;
	}
</style>
@stop
@section('content')
	<legend>{{$page->name}} @if($can_insert)<small><a href='{{action("PageController@getInsert",[$page->name])}}'>Add</a></small>@endif</legend>
    @if(isset($message))
        <label class='label label-{{$message_type}}'>{!!$message!!}</label><br/>
    @endif
	@if(count($data)==0)
		No data available!<br/>
	@else
		<table>
			<thead>
				<tr>
				@foreach($cols as $col)
					<th class='col-th-{{$col->name}}'>{{$col->final_value('label')}}</th>
				@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach($data as $datum)
				<tr>
					@foreach($cols as $col)
					<?php $col_name=$col->name;?>
						<td class='col-td-{{$col->name}}'>{{$datum->$col_name}}</td>
					@endforeach
					@if($can_edit)<td><a class='btn btn-link' href="{{action('PageController@getEdit',[$page->name]).'?'.$datum->edit_args}}"/>Edit</a></td>@endif
				</tr>
				@endforeach
			</tbody>
		</table>
		@if($has_more)
			<a class='btn btn-link' href="{{action('PageController@getView',[$page->name]).'?offset='.($current_offset + count($data))}}">More</a>
		@endif
	@endif
	<script type="text/javascript">
		$(document).ready(function(){
			if(document.location.hash) {
				var h = document.location.hash.substr(1);
				$('.col-th-'+h+', .col-td-'+h).css({backgroundColor:'wheat'});
			}
		})
	</script>
@stop