@extends('panel.frame')
@section('content')
	<h2>
		Welcome to GetPanel!
	</h2>
	<p>
		I am an open source software so you may use me in order to speed up your database content management!
	<p>
		@if($user->type===0)<a href='{{action('HomeController@getStep2')}}'>Click here</a> to proceed.@endif
	</p>
	@if(isset($pages))
		<h3>Pages:</h3>
	    @foreach($pages as $page)
	        @if($page->user_accessibility($user,'>'))
	        	{{$page->name}}
	        	@if($user->type===0)
	        		<a href='{{action("PageGenerationController@getEdit",$page->name)}}'>Edit</a> / 
	        	@endif
	         	@if($page->user_accessibility($user,'+'))
	         		<a href='{{action("PageController@getInsert",$page->name)}}'>Feed</a> /
	         	@endif
	         		<a href='{{action("PageController@getView",$page->name)}}'>Entries</a><br/>
	    	@endif
	    @endforeach
    @endif
    @if($user_groups)
    	<h3>User Groups</h3> <a href='{{action("Auth\\UserGroupController@getIndex")}}'>Manage</a>
    @endif
    @if($users)
    	<h3>Existing Users</h3> <a href='{{action("Auth\\UserController@getIndex")}}'>Manage</a>
    @endif
@stop