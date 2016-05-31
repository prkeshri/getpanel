<?php
namespace App\Models\Display;
trait DisplaySetting
{
	public $_display;
	public function label($val=NULL)
	{
		$title=$this->display('title',$val);
		if(!$title) $title=$this->name;
		return $title;
	}
	function display($x,$val=NULL)
	{
		if($val)
			$this->_display[$x]=$val;
		else
			return @$this->_display[$x];
	}
}