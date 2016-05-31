<?php
namespace App\Models;
abstract class PermanentStorage
{
	static $owners_stack=[];
	static $config_prefix='_x_';
	public $__owner=NULL,$is_imported,$__no_export;
	function export_filename()
	{
		if(static::$config_prefix===NULL) return NULL;
		$name=isset(static::$PermanentStorageKey)?static::$PermanentStorageKey:'name';
		$export_filename=static::$config_prefix.$this->$name;
		if($this->__owner)
			$export_filename=$this->__owner->export_filename().'@'.$export_filename;
		return $export_filename;
	}
	function export()
	{
		$export_filename = $this->export_filename();
		if($export_filename===NULL) return NULL;
		if($this->__no_export) return $export_filename;
		if(in_array($this, static::$owners_stack)!==FALSE) return $export_filename;
		$owner=$this->__owner;
		static::$owners_stack[]=$this->__owner;
		$rep = serialize($this);
		array_pop(static::$owners_stack);
		if($rep[0]!=='r' && $rep[1]!=='r')
		{

		 if(count(explode('r:', $rep))>1 || count(explode('R:', $rep))>1);
		// {
		// 	dd($export_filename,$this,$rep,debug_backtrace());
		// }
		else	user_config_save($export_filename,[$rep]);
		}
		return $export_filename;
	}

	// function __sleep()
	// {
	// 	$vars = get_object_vars($this);
	// 	$index = array_search('__owner', $vars);
	// 	if($index!==FALSE) array_splice($vars, $index,1);
	// 	return $vars;
	// }
	static function import($export_filename,$owner=NULL)
	{
		$rep=@user_config($export_filename.'.0');
		if(!$rep) return NULL;
		$rep=$rep[0];
		$obj=unserialize($rep);
		if($owner) $obj->__owner=ref($owner);
		$obj->is_imported=TRUE;
		Ref::resolve_back_references();
		return ref($obj);
	}
}