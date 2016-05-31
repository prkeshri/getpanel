<div class="form-group">
  <label class="col-md-4 control-label" for="{{$control_id}}">{{$label}}</label>  
  <div class="col-md-4">
  <textarea id="{{$control_id}}" name="{{$control_name}}" {{$is_readonly?'readonly':''}} type="text" placeholder="{{$placeholder_text}}" class="form-control input-md" value="{{$default_val}}"></textarea> @if($control_null_name) <label><input @if($default_val===NULL) checked @endif type='checkbox' name='{{$control_null_name}}'>Null</label> @endif
  <span class="help-block">{{$help_text}}</span>  
  </div>
</div>