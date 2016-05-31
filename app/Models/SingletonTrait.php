<?php
namespace App\Models;

trait SingletonTrait
{
	private static $single_instance;
	public static function i()
	{
		if(!static::$single_instance)
		{
			$i = static::import(static::$config_prefix);
			if(!$i) $i=new static;
			static::$single_instance = $i;
		}
		return static::$single_instance;
	}
}