<div class="form-group">
  <label class="col-md-4 control-label" for="{{$control_id}}"><a href="{{action('PageController@getView',[$col->references_table_name])}}#{{$col->references_col_name}}" target='_blank'>{{$label}}</a></label>  
  <div class="col-md-4">
  <select @if(isset($col->extra_info['list_more'])) onchange='selectValueIfMore(this,{{$col->extra_info['list_more']}})' @endif id="{{$control_id}}" name="{{$control_name}}" {{$is_readonly?'readonly':''}} placeholder="{{$placeholder_text}}" class="form-control">
  @if(isset($col->extra_info['list_values']))
	  @foreach($col->extra_info['list_values'] as $value => $label)
	  	<option @if($default_val == $value) selected @endif value='{{$value}}'>{{$label}}</option>
	  @endforeach
  @endif
  @if(isset($col->extra_info['list_more']))
    <option data-more='more'>more..</option>
  @endif
  </select> @if($control_null_name) <label><input @if($default_val===NULL) checked @endif type='checkbox' name='{{$control_null_name}}'>Null</label> @endif
  <span class="help-block">{{$help_text}}</span>  
  </div>
</div>