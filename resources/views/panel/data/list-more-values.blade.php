<!DOCTYPE html>
<html>
<head>
	<title>Choose...</title>
	<style type="text/css">
	table {
		border-collapse: collapse;
	}
	table td {
		border:solid 1px;
		text-align: center
	}
	</style>
</head>
<body>
	<table style='width:100%'>
		<thead>
			<tr>
				<th style='width:20%'>Value</th>
				<th>Text</th>
			</tr>
		</thead>
		<tbody>
			@foreach($list_values as $value => $label)
				<tr>
					<td><a href='#' onclick="sendValue('{{$value}}','{{$label}}')">{{$value}}</a></td>
					<td><a href='#' onclick="sendValue('{{$value}}','{{$label}}')">{{$label}}</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>
	@if($next_query)
		<a href='{{action("PageController@getListMore")}}?{{$next_query}}'>More</a>
	@endif
</body>
<script type="text/javascript">
	function sendValue(value,label)
	{
	    var control_id = <?php echo json_encode($_GET['control_id']); ?>;
	    window.opener.updateValue(control_id, value,label);
	    window.close();
	}
</script>
</html>