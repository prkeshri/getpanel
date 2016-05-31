@extends('panel.frame')
@section('content')
	<div style='margin:auto'>
		<p>
			Please make sure you have followed the steps given in the readme file.<br/>
			<p>
				@if($basic['save_in']=='folder')
					I have detected that you have assigned a folder and wish to continue saving settings in it.<br/>
					Please make sure this folder {{$basic['folder']['path']}} is writable.
				@elseif($basic['save_in']=='database')	
					I have detected that you have assigned a database connection and wish to continue saving settings in it.<br/>
					Please make sure this is accessible.
				@endif
				<hr/>
				<br/>
				I understand.
				<a href='{{action('TableController@getIndex')}}'>Click here</a> to proceed!
	</div>
@stop