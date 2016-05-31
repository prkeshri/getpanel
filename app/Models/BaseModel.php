<?php
namespace App\Models;
class BaseModel extends PermanentStorage
{
	function __construct($init=array())
	{
		foreach ($init as $key => $value)
		{
			$this->$key=$value;
		}
	}
	function __get($prop)
	{
		if(method_exists($this, $prop))
			return $this->$prop();
		else
			throw new \Exception(get_called_class()." Invalid property $prop", 1);
			
	}
	function __set($prop,$val)
	{
		if(method_exists($this, $prop))
			return $this->$prop($val);
		else
			throw new \Exception(get_called_class()." Invalid property $prop", 1);
			
	}
	static function get_vars($obj)
	{
		return get_object_vars($obj);
	}
	static function __set_state($state_arr)
	{
		$x=new static;
		foreach ($state_arr as $key => $value) {
			$x->$key=$value;
		}
		return $x;
	}
	static function create($arr)
	{
		return static::__set_state($arr);
	}

	static function count()
	{
		return count(user_config_all(static::$config_prefix,TRUE));
	}
	static function all()
	{
		$instances = user_config_all(static::$config_prefix);
		foreach ($instances as &$instance) {
			$instance=unserialize($instance[0]);
		}
		return $instances;
	}

	static function find($id)
	{
		$name=isset(static::$PermanentStorageKey)?static::$PermanentStorageKey:'name';
		$ins = @user_config_find(static::$config_prefix,$id)[0];
		if($ins) $ins=ref(unserialize($ins));
		return $ins;
	}
    static function import_by_id($id)
    {
        return unref(static::import(static::$config_prefix.$id));
    }
}