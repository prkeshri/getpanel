<?php
namespace App\Models;
class Ref implements \Serializable
{
	static $resolves=[],$back_references=[];
	private $target;

	function __construct($target)
	{
		if($target instanceOf self) $target=$target->target;
		$this->target=$target;
		static::$resolves[$target->export_filename()]=$target;
	}
	function export()
	{
		if(!$this->target) return '';
		return $this->serialize();
	}
	function serialize()
	{
		if(!$this->target) return '';
		
		return $this->target->export();
	}
	function unserialize($key)
	{
		if(empty(static::$resolves[$key]))
		{
			static::$resolves[$key]='-';
			$x = @user_config($key);
			$x=$x[0];
			try {
				$x = unserialize($x);
			} catch (Throwable $e) {
				$x = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $x);
				$x = unserialize($x);
			}
			if($x) $x->is_imported=true;
			static::$resolves[$key]=$x;
		}
		elseif(static::$resolves[$key]==='-')
		{
			if(empty(static::$back_references[$key])) static::$back_references[$key]=[];
			static::$back_references[$key][]=$this;
			return;
		}
		$this->target = static::$resolves[$key];
	}
	function __clone()
	{
		$this->target=clone $this->target;
	}
	function __get($k){ if($this->target) return $this->target->$k;}
	function __set($k,$v){ if($this->target) $this->target->$k=$v;}
	function __call($m,$args){ if($this->target) return call_user_func_array([$this->target,$m], $args);}
	static function resolve_back_references()
	{
		foreach (static::$back_references as $key => $mine_arr)
		{
			foreach ($mine_arr as $mine)
			{
				$mine->target=static::$resolves[$key];
				if($mine->target==='-') dd(debug_backtrace());
			}
		}
	}
	static function get_vars($r)
	{
		if($r instanceOf static) return BaseModel::get_vars($r->target);
		else return BaseModel::get_vars($r);
	}
	static function unref($ref)
	{
		return $ref->target;
	}
}