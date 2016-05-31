<html>
<head>
	<script src='/js/jquery-1.12.0.min.js' x-src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href='/css/bootstrap.min.css' x-href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src='/js/bootstrap.min.js' x-src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<style type="text/css">
	.label a
	{
		color:inherit;
		text-decoration: underline
	}
	</style>
	@yield('extra')
</head>
<body>
<div class='container-fluid'>
	<div>
		<div class="page-header">
			<div>
				<span class='h1' onclick='window.location.href="{{ url('/home') }}";' style='cursor:pointer'>GetPanel <small>Panel for any database!</small></span>
				<div class="pull-right">
					<ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
				</div>
			</div>
		</div>
		@yield('content')
	</div>
</div>
</body>