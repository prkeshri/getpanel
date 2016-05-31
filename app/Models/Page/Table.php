<?php
namespace App\Models\Page;
use \DB;
class Table extends \App\Models\Display\Table
{
	static $ColumnClass='\App\Models\Page\Column';
	use InnerAccess;
	function fetch_from_db($expand_ref=FALSE)
	{

	}
	static function import_or_new_with($name,$settings)
	{
		$me=static::import($name);
		
		if($me)
			return $me;
		$me=new static;
		$containee=$settings['containee'];
		$containee->__no_export=TRUE;
		foreach (get_vars($containee) as $key => $value)
		{
			if($key!=='_cols')
			{
				if(is_object($value))
				{
					$me->$key= $v = clone $value;
				}
	            else
	            	$me->$key = $value;
    		}
        }
        $me->_cols=[];
        $ColumnClass=static::$ColumnClass;
        foreach ($containee->cols as $ccol)
        {
        	$state_arr=[];
        	foreach (get_vars($ccol) as $key => $value)
			{
	            if($key!='__owner' && is_object($value))
	            {
					$v = ref(clone $value);
					$state_arr[$key]=$v;
	            }
	            else
	            	$state_arr[$key]= $value;
	        }
			$state_arr['__owner']=ref($me);
			$state_arr['__no_export']=FALSE;
			$c=$ColumnClass::__set_state($state_arr);
			$c->containee = ref($ccol);
	        $me->_cols[]=ref($c);
        }
        $me->containee=ref($containee);
        $me->__no_export=FALSE;
        return $me;
	}
	static function import($name,$set_owner = NULL)
	{
		$me=parent::import($name,$set_owner);
		if(!$me) return NULL;
		foreach ($me->cols as $col)
		{
			$col->__owner=ref($me);
		}
		return $me;
	}

	function read_values($read_value_obj)
	{
		foreach ($this->cols as $col)
		{
			$col_name=$col->name;
			$col->set_client_value($read_value_obj->$col->name);
		}
	}
	private function client_feed($mode='+')
	{
		$feed_data = array();
		foreach ($this->cols as $col)
		{
			if($col->is_autoinc && $col->get_client_value()==NULL) continue;
			$feed_data[$col->name]=$col->get_client_value($mode);
		}
		return $feed_data;
	}
	function insert_from_client_values()
	{
		return data_db()->table(DB::raw($this->name))->insert($this->client_feed('+'));
	}
	function update_from_client_values_and_edit_args($edit_args)
	{
		$wheres=$edit_args;
		return data_db()->table(DB::raw($this->name))->where($wheres)->update($this->client_feed('.'));
	}
}