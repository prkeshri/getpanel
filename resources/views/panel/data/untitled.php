<div class="form-group">
<?php  if(!$default_val) $default_val=''; $default_vals = @explode(',', $default_val); ?>
  <label class="col-md-4 control-label" for="{{$control_id}}">{{$label}}</label>  
  <div class="col-md-4">
  <select multiple id="{{$control_id}}" name="{{$control_name}}" {{$is_readonly?'readonly':''}} placeholder="{{$placeholder_text}}" class="form-control">
  @if(isset($col->extra_info['list_values']))
	  @foreach($col->extra_info['list_values'] as $value)
	  	<option @if(in_array($value, $default_vals)) selected @endif value='{{$value}}'>{{$value}}</option>
	  @endforeach
  @endif
  </select> @if($control_null_name) <label><input type='checkbox' name='{{$control_null_name}}'>Null</label> @endif
  <span class="help-block">{{$help_text}}</span>  
  </div>
</div>