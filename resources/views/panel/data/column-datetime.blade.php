<div class="form-group">
  <label class="col-md-4 control-label" for="{{$control_id}}">{{$label}}</label>  
  <div class="col-md-4">
    <div class='input-group date {{$col->type}}picker' id='{{$control_id}}'>
        <input type='text' class="form-control" {{$is_readonly?'readonly':''}} name="{{$control_name}}" placeholder="{{$placeholder_text}}" value="{{$default_val}}"/>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
    @if($control_null_name) <label><input type='checkbox' @if($default_val===NULL) checked @endif name='{{$control_null_name}}'>Null</label> @endif
    <span class="help-block">{{$help_text}}</span> 
  </div>
  <?php $col->extra_info['use-date-picker'] = true; ?>
</div>