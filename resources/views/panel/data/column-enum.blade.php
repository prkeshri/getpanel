<div class="form-group">
  <label class="col-md-4 control-label" for="{{$control_id}}">{{$label}}</label>  
  <div class="col-md-4">
  <select id="{{$control_id}}" name="{{$control_name}}" {{$is_readonly?'readonly':''}} placeholder="{{$placeholder_text}}" class="form-control">
  @if(isset($col->extra_info['list_values']))
	  @foreach($col->extra_info['list_values'] as $value)
	  	<option @if($default_val == $value) selected @endif value='{{$value}}'>{{$value}}</option>
	  @endforeach
  @endif
  </select> @if($control_null_name) <label><input type='checkbox' @if($default_val===NULL) checked @endif name='{{$control_null_name}}'>Null</label> @endif
  <span class="help-block">{{$help_text}}</span>  
  </div>
</div>