<?php
namespace App\Util\TableBuilder;
class UI_With_Custom
{
	var $ui,$ui_mine,$wrapper_obj;
	static function with_name_prefix($name_prefix,$custom_name_prefix=NULL,$wrapper_obj)
	{
		if(!$custom_name_prefix) $custom_name_prefix='[use_custom]';
		$me=new UI_With_Custom;
		$me->ui=UI::with_name_prefix($name_prefix);
		$me->ui_mine=UI::with_name_prefix($name_prefix.$custom_name_prefix);
		$me->wrapper_obj=$wrapper_obj;
		return $me;
	}
	function __call($m,$params)
	{
		$x=call_user_func_array([$this->ui,$m], $params);
		$key=@$params[0];
		if(!$key) return $x;
		$y=$this->ui_mine->yes_no_options($key,@$this->wrapper_obj->use_custom_values[$key],"Use this setting","Use original setting");
		return $x.'<br/>'.$y.'<br/>';
	}
}