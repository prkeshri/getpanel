@extends('panel.frame')
@section('content')
<form class="form-horizontal" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<fieldset>

<!-- Form Name -->
<legend>Miscelleneous settings for each page</legend>
I will apply these settings before any table customization:<br/>
Please note that any tables/pages created already won't be applied by this.
<hr/>
<div class='container-fluid'>
	<div class='row'>
		<div class='col-md-1'><label><input type='checkbox' value='true' @if(@$setting['_autoinc']['apply']) checked @endif name='setting[_autoinc][apply]'/>Apply this</label>
		</div>
		<div class='col-md-4'>Auto inc field</div>
		<div class='col-md-7'>
							<input type='radio' value='true' id='setting[_autoinc]_is_visible' @if(@$setting['_autoinc']['is_visible']) checked @endif name='setting[_autoinc][is_visible]' <label for='setting[_autoinc]_is_visible'>Visible for input.</label> <input type='radio' value='false' id='setting[_autoinc]_is_visible_no' @if(!@$setting['_autoinc']['is_visible']) checked @endif name='setting[_autoinc][is_visible]'  /><label for='setting[_autoinc]_is_visible_no'>Not!</label><br/>
							<input type='radio' value='true' id='setting[_autoinc]_is_null_allowed' @if(@$setting['_autoinc']['is_null_allowed']) checked @endif name='setting[_autoinc][is_null_allowed]'  /><label for='setting[_autoinc]_is_null_allowed'>Allow null entry</label> <input type='radio' value='false' id='setting[_autoinc]_is_null_allowed_no' @if(!@$setting['_autoinc']['is_null_allowed']) checked @endif name='setting[_autoinc][is_null_allowed]' <label for='setting[_autoinc]_is_null_allowed_no'>Not!</label><br/>
							<input type='radio' value='true' id='setting[_autoinc]_is_readonly' @if(@$setting['_autoinc']['is_readonly']) checked @endif name='setting[_autoinc][is_readonly]'  /><label for='setting[_autoinc]_is_readonly'>Readonly field(Reason(s):Auto increment)</label> <input type='radio' value='false' id='setting[_autoinc]_is_readonly_no' @if(!@$setting['_autoinc']['is_readonly']) checked @endif name='setting[_autoinc][is_readonly]' <label for='setting[_autoinc]_is_readonly_no'>Not!</label><br/><br/>
					</div>
	</div>
	<div class='row'>
		<div class='col-md-1'><label><input type='checkbox' value='true' @if(@$setting['created_at']['apply']) checked @endif name='setting[created_at][apply]'/>Apply this</label>
		</div>
		<div class='col-md-4'>created_at</div>
		<div class='col-md-7'>
							<input type='radio' value='true' id='setting[created_at]_is_visible' @if(@$setting['created_at']['is_visible']) checked @endif name='setting[created_at][is_visible]' <label for='setting[created_at]_is_visible'>Visible for input.</label> <input type='radio' value='false' id='setting[created_at]_is_visible_no' @if(!@$setting['created_at']['is_visible']) checked @endif name='setting[created_at][is_visible]'  /><label for='setting[created_at]_is_visible_no'>Not!</label><br/>
							<input type='radio' value='true' id='setting[created_at]_is_current_datetime_on_insert' @if(@$setting['created_at']['is_current_datetime_on_insert']) checked @endif name='setting[created_at][is_current_datetime_on_insert]'  /><label for='setting[created_at]_is_current_datetime_on_insert'>Current datetime on INSERT.</label> <input type='radio' value='false' id='setting[created_at]_is_current_datetime_on_insert_no' @if(!@$setting['created_at']['is_current_datetime_on_insert']) checked @endif name='setting[created_at][is_current_datetime_on_insert]' <label for='setting[created_at]_is_current_datetime_on_insert_no'>Not!</label><br/>
							<input type='radio' value='true' id='setting[created_at]_is_current_datetime_on_update' @if(@$setting['created_at']['is_current_datetime_on_update']) checked @endif name='setting[created_at][is_current_datetime_on_update]'  /><label for='setting[created_at]_is_current_datetime_on_update'>Current datetime on UPDATE.</label> <input type='radio' value='false' id='setting[created_at]_is_current_datetime_on_update_no' @if(!@$setting['created_at']['is_current_datetime_on_update']) checked @endif name='setting[created_at][is_current_datetime_on_update]' <label for='setting[created_at]_is_current_datetime_on_update_no'>Not!</label><br/>
					</div>
	</div>
	<div class='row'>
		<div class='col-md-1'><label><input type='checkbox' value='true' @if(@$setting['updated_at']['apply']) checked @endif name='setting[updated_at][apply]'/>Apply this</label>
		</div>
		<div class='col-md-4'>updated_at</div>
		<div class='col-md-7'>
							<input type='radio' value='true' id='setting[updated_at]_is_visible' @if(@$setting['updated_at']['is_visible']) checked @endif name='setting[updated_at][is_visible]' <label for='setting[updated_at]_is_visible'>Visible for input.</label> <input type='radio' value='false' id='setting[updated_at]_is_visible_no' @if(!@$setting['updated_at']['is_visible']) checked @endif name='setting[updated_at][is_visible]'  /><label for='setting[updated_at]_is_visible_no'>Not!</label><br/>
							<input type='radio' value='true' id='setting[updated_at]_is_current_datetime_on_insert' @if(@$setting['updated_at']['is_current_datetime_on_insert']) checked @endif name='setting[updated_at][is_current_datetime_on_insert]'  /><label for='setting[updated_at]_is_current_datetime_on_insert'>Current datetime on INSERT.</label> <input type='radio' value='false' id='setting[updated_at]_is_current_datetime_on_insert_no' @if(!@$setting['updated_at']['is_current_datetime_on_insert']) checked @endif name='setting[updated_at][is_current_datetime_on_insert]' <label for='setting[updated_at]_is_current_datetime_on_insert_no'>Not!</label><br/>
							<input type='radio' value='true' id='setting[updated_at]_is_current_datetime_on_update' @if(@$setting['updated_at']['is_current_datetime_on_update']) checked @endif name='setting[updated_at][is_current_datetime_on_update]'  /><label for='setting[updated_at]_is_current_datetime_on_update'>Current datetime on UPDATE.</label> <input type='radio' value='false' id='setting[updated_at]_is_current_datetime_on_update_no' @if(!@$setting['updated_at']['is_current_datetime_on_update']) checked @endif name='setting[updated_at][is_current_datetime_on_update]' <label for='setting[updated_at]_is_current_datetime_on_update_no'>Not!</label><br/>
					</div>
	</div>

	<input type="submit"/>
</div>
</fieldset>
</form>
@stop