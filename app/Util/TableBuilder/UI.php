<?php
namespace App\Util\TableBuilder;
class UI
{
	protected $_name_prefix='';
	static function with_name_prefix($name_prefix)
	{
		$ui=new UI;
		$ui->_name_prefix=$name_prefix;
		return $ui;
	}
	function yes_no_options($key,$val,$yes_label,$no_label=NULL,$yes_extra='',$no_extra='')
	{
		$name_prefix=$this->_name_prefix;
		if(!$no_label) $no_label="Not!";
		$yes="<input type='radio' value='true' id='{$name_prefix}_{$key}' name='{$name_prefix}[{$key}]' ".
			($val?'checked':'').
			" $yes_extra/><label for='{$name_prefix}_{$key}'>{$yes_label}</label>";
		$no="<input type='radio' value='false' id='{$name_prefix}_{$key}_no' name='{$name_prefix}[{$key}]' ".
			($val?'':'checked').
			" $no_extra/><label for='{$name_prefix}_{$key}_no'>{$no_label}</label>";
		return $yes.' '.$no;
	}
	function textarea($key,$val,$label)
	{
		$name_prefix=$this->_name_prefix;
		$x='';
		if($label) $x="<label for='{$name_prefix}_{$key}'>$label: </label>";
		$x.="<textarea  id='{$name_prefix}_{$key}' name='{$name_prefix}[{$key}]'>".htmlentities($val)."</textarea>";
		return $x;
	}
	function input($key,$val,$label)
	{
		$name_prefix=$this->_name_prefix;
		$x='';
		if($label) $x="<label for='{$name_prefix}_{$key}'>$label: </label>";
		$x.="<input name='{$name_prefix}[{$key}]' id='{$name_prefix}_{$key}' value='$val'/>";
		return $x;
	}
}
