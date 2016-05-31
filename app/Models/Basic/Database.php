<?php
namespace App\Models\Basic;

use App\Models\BaseModel;
class Database extends BaseModel
{
	static $list=[];
	static $TableClass='Table';
	
	public $name;
	protected $_tables;
	function __construct($init=[])
	{
		$this->_tables=[];
		if(is_array($init))
			parent::__construct($init);
		else
			$this->name=$init;
		if(!$this->name)
			$this->name=data_db_name();

		static::$list[$this->name]=$this;
	}
    function tables()
	{
		if($this->_tables)
			return $this->_tables;

		$this->_tables=[];
		$db_name=$this->name;

		$_tables=data_db()->select("SELECT TABLE_NAME
							FROM INFORMATION_SCHEMA.tables 
							WHERE TABLE_SCHEMA=?",[$db_name]);
		foreach ($_tables as $table_info)
		{
			$table_name=$table_info->TABLE_NAME;
			if(@$this->_tables[$table_name])
				continue;
			else
				$this->_tables[$table_name]=ref($this->table($table_name,TRUE));
		}
		return $this->_tables;
	}
	function table($name,$expand_ref=TRUE)
	{
		if($this->_tables && @$this->_tables[$name])
			return $this->_tables[$name];
		else
		{
			$table=new static::$TableClass($name,$this->name,$this);
			$table->fetch_from_db($expand_ref);
			$this->_tables[$name]=ref($table);
			return $table;
		}
	}

	static function by_name($name)
	{
		return @static::$list[$name];
	}

}