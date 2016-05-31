<?php
namespace App\Models\Page;

class Page extends \App\Models\Display\Database
{
	use InnerAccess;
	static $TableClass='\App\Models\Page\Table';
	public $base_table;
	static $config_prefix='page_';
	protected $_user_group_permissions=[];
	static function import_or_new($name=NULL,$only_table_with_name=NULL)
	{
		throw new Exception("I don't support this!", 1);
	}
	static function import_or_new_with($name,$settings)
	{
		$me=static::import($name);
		if($me) return $me;
		return static::new_with($name,$settings);
	}
	static function new_with($name,$settings)
	{
		$me=new static;
		$me->name=$name;
		$me->containee=ref($settings['db']);
		$me->base_table=ref($me->table($settings['base_table']->name));
		return $me;
	}
	function table($name,$expand_ref=TRUE)
	{
		$TableClass=static::$TableClass;
		if($this->_tables && @$this->_tables[$name])
			return $this->_tables[$name];
		else
		{
			$temp=$this->containee->table($name,$expand_ref);
			if($temp)
			{
				$table=$TableClass::import_or_new_with($this->export_filename().'@'. $TableClass::$config_prefix. $name,['containee'=>$temp]);
				$table->__owner=ref($this);
				return ref($this->_tables[$name]=ref($table));
			}
		}
	}
	function user_group_permissions($new_permissions=NULL)
	{
		if($new_permissions===NULL) return $this->_user_group_permissions;
		$this->_user_group_permissions=[];
		if($new_permissions!=="") 
			foreach ($new_permissions as $user_group_id => $new_permissions)
			{
				$new_permissions_bool = [];
				foreach ($new_permissions as $key => $value) {
					$new_permissions_bool[$key]=true;
				}
				$new_permissions_bool['>']=true;
				$this->_user_group_permissions[$user_group_id]=$new_permissions_bool;
			}
		return $this;
	}
	function user_accessibility($user,$permission)
	{
		foreach ($user->user_groups as $user_group)
		{
			if(isset($this->_user_group_permissions[$user_group->id][$permission]))
				return TRUE;
		}
		return FALSE;
	}
}