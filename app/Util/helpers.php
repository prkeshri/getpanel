<?php
/*
	Commonly used utility functions
*/
	function array_map_by_key($arr,$key)
	{
		return array_map(function($obj) use($key){
			return $obj->$key;
		}, $arr);
	}

	function to_bool(&$v)
	{
		if($v===true || $v===false) return $v;
		if($v==='true') $v=true; else $v=false;
		return $v;
	}

	function to_bool_recursive($vs)
	{
		if(is_array($vs))
			foreach ($vs as $key => $value)
			{
				$value = to_bool_recursive($value);
				$vs[$key]=$value;
			}
		else
			to_bool($vs);
		return $vs;
	}
	function array_remove_keys($haystack,$needles)
	{
		if(!is_array($needles)) $needles=[$needles];
		$ret=$haystack;
		foreach ($needles as $key)
		{
			unset($ret[$key]);
		}
		return $ret;
	}

	function http_redirect($url='/')
	{
		header("Location: $url");
		die();
	}

	function ref($target)
	{
		if(!$target) return NULL;
		return new App\Models\Ref($target);
	}
	function unref($ref)
	{
		if($ref instanceOf App\Models\Ref) return App\Models\Ref::unref($ref);
		else return $ref;
	}
	function get_vars($o)
	{
		return App\Models\Ref::get_vars($o);
	}
require_once(__DIR__.'/helpers2.php');