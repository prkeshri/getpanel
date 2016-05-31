<?php
namespace App\Models;
trait BoolTrait
{
	function __get($var)
	{
		$_var="_{$var}";
		if(property_exists($this,$_var))
			return $this->$_var;
		else
			return parent::__get($var);
	}
	function __set($var,$val)
	{
		$_var="_{$var}";
		if(property_exists($this,$_var))
		{
			if(substr($var, 0,3)=='is_')
				to_bool($val);
			$this->$_var=$val;
		}
		else
			parent::__set($var,$val);
	}
}