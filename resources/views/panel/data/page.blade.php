@extends('panel.frame')
@section('content')
<?php $extra_infos = []; ?>
<form class="form-horizontal" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<fieldset>

<!-- Form Name -->
<legend>{{$page->name}} <small style='font-size:.5em'><a href='{{action("PageController@getView",$page->name)}}'>Entries</a></small></legend>
		
	@foreach($page->tables as $table)
		@foreach($table->cols as $col)
			{!!$col->client_ui('v['.$table->name.']['.$col->name.']',$mode)!!}
            <?php if(isset($col->extra_info['use-date-picker'])) $extra_infos['use-date-picker'] = true; ?>
		@endforeach
	@endforeach
	<input type="submit" value="Save"/>
    @if(isset($message))
        <label class='label label-{{$message_type}}'>{!!$message!!}</label><br/>
    @endif
</fieldset>
</form>
  <script type="text/javascript">
    function selectValueIfMore(control,table,col,offset)
    {
        // open popup window and pass field id
        <?php
        	$url = action("PageController@getListMore",[$page->name]);
        ?>
        if(!$(control).find('option:selected').attr('data-more')) return;
        var control_id=control.id;
        var param = $.param({control_id:control_id, table:table,col:col,offset:offset});
        window.open('{{$url}}?'+param,'list-page',
          'width=400,toolbar=1,resizable=1,scrollbars=yes,height=400,top=100,left=100');
    }

    function updateValue(control_id, value, label)
    {
    	value=''+value;
        // this gets called from the popup window and updates the field with a new value
        var select=$(document.getElementById(control_id));
        if(select.find("option[value='"+value.split("'").join("\\'")+"']").length <= 0)
        {
        	var option=$('<option>');
	        option.attr('value',value);
	        option.text(label);
	        select.append(option)
    	}
    	select.val(value);
    }
    @if(isset($other_data['opener_refresh']))
        window.opener && alert("Please refresh the entry page which had opened this window in order to use currently saved values!")
    @endif
  </script>
    @if(isset($extra_infos['use-date-picker']))
      @include('panel.blocks.datepicker-extra')
    @endif
@stop