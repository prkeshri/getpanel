@extends('panel.frame')
@section('content')
	<div style='margin:auto'>
		@if(isset($message))
			<label class='label label-{{$message_type}}'>{!!$message!!}</label>
		@endif
		<h3>
			Page for : <a href={{action('TableController@getSet',[$table->name])}}>{{$table->name}}</a>
			<small>(You may override these settings custom to this page.)</small>
		</h3>@if($update_mode) 
				<a href='{{action("PageController@getInsert",$existing_page->name)}}'>Feed</a> / <a href='{{action("PageController@getView",$existing_page->name)}}'>Entries</a>
			@endif
			<form method='post'> 
				<label>Page name</label> :
				<input type='text' name='page_name' class='input input-sm' value='{{$table->name}}'  @if($update_mode) readonly @endif required/>
				@if(!$update_mode && $existing_page->is_imported) 
					<br/>
					Warning: Page with this name already exists! We have copied this setting from the existing page with this name. Please change this name before saving. This would create a new page!
				@endif
				<hr/>
				<div class='row'>
				<h4 class='col-md-1'>Column</h4>
				<div class='col-md-2'>Label</div>
				<div class='col-md-2'>Default Value</div>
				<div class='col-md-7'>Miscelleneous Settings</div>
				</div>
				@include('panel.blocks.table',['mode'=>'page'])
				Access Permissions:<br/>
				<div class='row'>
				@foreach($user_groups as $user_group)
					<div class='col-md-4'>
						<label>{{$user_group->name}}</label> :
						<!--<label>
							<input type='checkbox' name='page[user_group_permissions][{{$user_group->id}}][>]' value='{{$user_group->id}}' @if((!$update_mode && $user_group->id===1) || isset($existing_page->user_group_permissions[$user_group->id]['>'])) checked @endif/>
							View
						</label>-->
						<label>
							<input type='checkbox' name='page[user_group_permissions][{{$user_group->id}}][+]' value='{{$user_group->id}}' @if((!$update_mode && $user_group->id===1) || isset($existing_page->user_group_permissions[$user_group->id]['+'])) checked @endif/>
							Insert
						</label>
						<label>
							<input type='checkbox' name='page[user_group_permissions][{{$user_group->id}}][.]' value='{{$user_group->id}}' @if(($user_group->id===1) || isset($existing_page->user_group_permissions[$user_group->id]['.'])) checked @endif/>
							Update
						</label>
					</div>
				@endforeach
				<a href='{{action("Auth\\UserGroupController@getIndex")}}'>manage user groups</a>
				</div>
				<hr/>
				<input type='submit' value='Save'/>
			</form>
	</div>
@stop