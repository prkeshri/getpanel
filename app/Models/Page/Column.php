<?php
namespace App\Models\Page;
class Column extends \App\Models\Display\Column
{
	use InnerAccess;

	function client_ui($name,$mode='+')
	{
		if(!$this->final_value('is_visible')) return '';
		if($this->references_table_name && $this->references_col_name )
		{
			$list_values = $this->references_table->select_list_values($this->references_col_name,20);
			if(!$this->extra_info) $this->extra_info = [];
			$this->extra_info['list_values'] = $list_values;
			if(count($list_values)==20) $this->extra_info['list_more']=implode(',', array_map(function($q){return '\''.$q.'\'';},[$this->references_table->export_filename(),$this->references_col_name,20]));
			$this->type = 'foreign';
		}
		$is_readonly=$this->final_value('is_readonly');
		if($this->type=='datetime') $this->type='datetime';
		$probable_view_name = 'panel.data.column-'.$this->type ;
		$view_name = view()->exists($probable_view_name) ? $probable_view_name : 'panel.data.column';
		return view($view_name,[
			'control_id'=>$name,
			'control_name'=>$name.'[value]',
			'label'=>$this->final_value('label'),
			'is_readonly'=>$is_readonly,
			'placeholder_text'=>$this->final_value('placeholder_text'),
			'default_val'=>($mode=='+')?$this->final_value('default_val'):$this->_client_value,
			'help_text'=>$this->final_value('help_text'),
			'control_null_name'=>((!$is_readonly && $this->final_value('is_null_allowed')) ? $name.'[null]':NULL),
			'col'=>$this]);
	}

	private $_client_value;
	function set_client_value($val)
	{
		if($this->final_value('is_readonly')) return FALSE;
		if($val===null && !$this->final_value('is_null_allowed')) return FALSE;
		
		if(is_array($val)) $val = implode(',', $val); //Multivalued types ex:Set
		
		if($this->_client_value == $val) return FALSE;
		$this->_client_value=$val;
		return TRUE;
	}
	function get_client_value($mode='+') //+ : Add, .:Update
	{
		if($mode=='+' && $this->final_value('is_current_datetime_on_insert'))
			$this->_client_value = $this->now();
		if($mode=='.' && $this->final_value('is_current_datetime_on_update'))
			$this->_client_value = $this->now();
		return $this->_client_value;
	}
	function now()
	{
		switch ($this->type)
		{
			case 'datetime':
				return date('Y-m-d h:i:s');
			case 'date':
				return date('Y-m-d');
			case 'time':
				return date('h:i:s');
			case 'timestamp':
				return time();
		}
	}
	function set_client_value_force($val) 
	{
		$this->_client_value=$val;
	}
}