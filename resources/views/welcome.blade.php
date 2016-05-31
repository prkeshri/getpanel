@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <h3>Pages:</h3>
                    @foreach($pages as $page)
                        {{$page->name}} <a href='edit'>Edit</a> <a href='{{action("PageController@getInsert",$page->name)}}')}}'>Feed</a> <a href='view'>Enteries</a><br/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
