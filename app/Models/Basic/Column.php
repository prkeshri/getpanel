<?php
namespace App\Models\Basic;

use App\Models\BaseModel;
class Column extends BaseModel
{
	public $name,

	   $type,
	   $type_len,
	   $is_unsigned,

	   $is_null,
	   $is_autoinc,
	   $is_primary,

	   $references_table_name, //if foreign key
	   $references_col_name,
	   $references_table,
	   $references_col,

	   $extra_info,

	   $_default;

	function __construct($init=[])
	{
		if(is_array($init))
			return parent::__construct($init);
		else
			$this->name=$init;
	}
	function default_val($v=NULL)
	{
		if($v!==NULL)
			$this->_default=$v;
		else return $this->_default;
	}
}