<?php
namespace App\Models\Display;

use App\Models\Basic\Database as BasicDatabase;

class Database extends BasicDatabase
{
	static $TableClass='\App\Models\Display\Table';
	static $config_prefix='db_';
	function __construct($init=[])
	{
		parent::__construct($init);
	}
	static function import_or_new($name=NULL,$only_table_with_name=NULL)
	{
		if($name==NULL) $name=data_db_name();

		$db=static::import($name);//,$only_table_with_name);
		if(!$db) $db=new static($name);
		return $db;
	}
	function table($name,$expand_ref=TRUE)
	{
		$TableClass=static::$TableClass;
		if($this->_tables && @$this->_tables[$name])
		{
			return $this->_tables[$name];
		}
		else
		{
			$table=$TableClass::import($this->export_filename().'@'. $TableClass::$config_prefix. $name);

			if(!$table)
				$table=parent::table($name,$expand_ref);
			$this->_tables[$name]=ref($table);
			return $table;
		}
	}
	static function import($name=NULL,$set_owner=NULL)
	{
		if(!$name) $name=data_db_name();
		$export_filename=static::$config_prefix.$name;
		return parent::import($export_filename,$set_owner);
	}
}