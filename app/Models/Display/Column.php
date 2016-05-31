<?php
namespace App\Models\Display;

use App\Util\TableBuilder\UI;
use App\Models\BoolTrait;
use App\Models\MiscellaneousSetting;
use App\Models\Basic\Column as BasicColumn;

class Column extends BasicColumn
{
	use DisplaySetting;
	use BoolTrait;
	static $config_prefix='c_';
	protected $_is_null_allowed;
	protected $_is_readonly;
	protected $_is_visible=true;
	protected $_is_current_datetime_on_insert;
	protected $_is_current_datetime_on_update;
	protected $_placeholder_text='';
	public $_help_text='';
	protected $_manual_ref_set=false;
	function __construct($init=[])
	{
		$this->_is_null_allowed=$this->is_null;
		if($this->is_autoinc)
			$this->_is_readonly=true;
		parent::__construct($init);
	}
	function set_reference_table_by_name($table_name)
	{
		if(!$table_name) return;
		$table=$this->db->table($table_name);
		$this->references_table_name=$table_name;
		$this->references_table=$table;
		$this->_manual_ref_set=true;
	}
	function set_reference_col_by_name($col_name)
	{
		if(!$col_name || !$this->references_table) return;
		$col=$this->references_table->col($col_name);
		$this->references_col_name=$col_name;
		$this->references_col=$col;
	}
	function extra_config_options($name_prefix,$ui=NULL)
	{
		$options=[];
		if(!$this->is_imported)
		{
			$ms = MiscellaneousSetting::i()->setting;
			if($this->is_autoinc && @$ms['_autoinc']['apply'])
			{
				foreach ($ms['_autoinc'] as $key => $value)
				{
					if($key!='apply') $this->$key=$value;
				}
			}
			if($this->name!='_autoinc' && @$ms[$this->name]['apply'])
				foreach ($ms[$this->name] as $key => $value)
				{
					if($key!='apply') $this->$key=$value;
				}
		}
		if(!$ui) $ui=UI::with_name_prefix($name_prefix); 
		$options[]=$ui->yes_no_options('is_visible',$this->_is_visible,'Visible for input.');
		if(!$this->is_null)
			$options[]=$ui->yes_no_options('is_null_allowed',$this->_is_null_allowed,'Allow null entry');
		if($this->is_autoinc)
			$options[]=$ui->yes_no_options('is_readonly',$this->_is_readonly,'Readonly field(Reason(s):Auto increment)');
		if($this->type=='datetime' || $this->type=='date' || $this->type=='time' || $this->type=='timestamp')
		{
			$options[]=$ui->yes_no_options('is_current_datetime_on_insert',$this->_is_current_datetime_on_insert,"Current ".$this->type." on INSERT.");
			$options[]=$ui->yes_no_options('is_current_datetime_on_update',$this->_is_current_datetime_on_update,"Current ".$this->type." on UPDATE.");
		}
		$options[]=$ui->textarea('help_text',$this->_help_text,'Help text to display to user');
		$options[]=$ui->input('placeholder_text',$this->_placeholder_text,'Placeholder text to display to user');
		if($this->_manual_ref_set || !$this->references_table)
		{
			$options[]=$ui->input('set_reference_table_by_name',$this->references_table_name,'Referencing table');
			$options[]=$ui->input('set_reference_col_by_name',$this->references_col_name,'Referencing column');
		}
		return $options;
	}
}