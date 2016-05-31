<?php
namespace App\Models\Display;

use \DB;
class Table extends \App\Models\Basic\Table
{
	static $ColumnClass='\App\Models\Display\Column';
	static $config_prefix='tab_';
	use DisplaySetting;
	function __construct($init=[],$db_name=NULL,$db=NULL)
	{
		parent::__construct($init,$db_name,$db);
	}
	function col_regex($regex)
	{
		foreach ($this->_cols as $col) 
		{
			if(preg_match($regex, $col->name))
				return $col;
		}
		return null;
	}
	function select_list_text()
	{
		$text=NULL;
		$display_cols=['title','name'];
		foreach ($display_cols as $dc)
		{
			if($display_col=$this->col_regex("/^$dc^/"))
			{
				$text='#'.$display_col->name.'#';
				break;
			}
		}
		if(!$text)
			foreach ($this->_cols as $col)
			{
				if(!$col->is_primary)
				{
					$text='#'.$col->name.'#';
					break;
				}
			}
	 	$this->_display['list_text']=$text;
	}
	function fetch_from_db($expand_ref=FALSE)
	{
		parent::fetch_from_db($expand_ref);
		if(!@$this->_display['list_text'])
			$this->select_list_text();
	}
	static function db_config_name()
	{
		return Database::config_name(Database::by_name(data_db_name()));
	}
	function select_list_values($incoming_ref_col_name,$limit=20,$skip=0)
	{
		$select_cols = array($incoming_ref_col_name);
		
		$list_text = $this->display('list_text');
		if(!$list_text) $list_text="#$incoming_ref_col_name#";

		$list_parts = explode('#', $list_text);

		for ($i=1; $i < count($list_parts); $i+=2)
		{ 
			$select_cols[]=$list_parts[$i];
		}

		$data = DB::table(DB::raw($this->name))->select($select_cols)->skip($skip)->take($limit)->get();
		$key_value = array();

		foreach ($data as $datum)
		{
			$list_parts_value = $list_parts;
			for ($i=1; $i < count($list_parts); $i+=2)
			{ 
				$list_parts_value[$i]=$datum->{$list_parts[$i]};
			}
			
			$key_value[$datum->$incoming_ref_col_name] = implode('', $list_parts_value);
		}
		return $key_value;
	}
}