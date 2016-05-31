<?php
namespace App\Models\Basic;

use App\Models\BaseModel;
class Table extends BaseModel
{
	static $ColumnClass='Column';
	
	public $name,
		   $_cols=[],
	       $primary_cols=[],

	       $outgoing_references=[],
	       $incoming_references=[],

	       $db_name,
	       $db;
	function __construct($init=[],$db_name=NULL,$db=NULL)
	{
		if(is_array($init))
			return parent::__construct($init);
		else
			$this->name=$init;
		if($db_name) $this->db_name=$db_name;
		if($db) $this->db=ref($db);

		if($this->db_name && !$this->db)
			$this->db=ref(Database::by_name($db_name));
		$this->__owner=ref($this->db);
	}
	function col($name)
	{
		foreach ($this->_cols as $col) 
		{
			if($col->name==$name)
				return $col;
		}
		return null;
	}
	function cols()
	{
		return $this->_cols ? $this->_cols : [];
	}
	/* Fetch from database */
	function fetch_from_db($expand_ref=FALSE)
	{
		$table_name=$this->name;
		$db_name=$this->db_name;
		$_cols=data_db()->select("DESC $db_name.$table_name");
		foreach ($_cols as $col => $col_info)
		{
			$is_primary=($col_info->Key=='PRI');

			$is_autoinc=(strpos($col_info->Extra, 'auto_increment') !==FALSE);

			$type_info=explode('(',$col_info->Type,2);

			$init=array(
				'name'=>$col_info->Field,
				'is_null'=>($col_info->Null=='YES'),
				'_default'=>$col_info->Default,
				'is_autoinc'=>$is_autoinc,
				'type'=>$type_info[0],
				'is_primary'=>$is_primary
			);

			if(count($type_info)>1)
			{
				if($type_info[0]=='enum' || $type_info[0]=='set')
				{
					$list_values = substr($type_info[1],0,-1);
					$list_values = str_getcsv($list_values,',','\'');
					$init['extra_info']=['list_values'=>$list_values];
				}
				$type_info=explode(' ', $type_info[1]);
				$init['type_len']=intval($type_info[0]);
				if(count($type_info)>1)
				{
					if($type_info[1]=='unsigned')
						$init['is_unsigned']=true;
				}
			}

			$init['__owner']=ref($this);
			$col=new static::$ColumnClass($init);
			array_push($this->_cols,ref($col));
			if($is_primary) 
				array_push($this->primary_cols,ref($col));
		}

		$outgoing_references=data_db()->select("SELECT 
		 				  COLUMN_NAME,REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
		 				FROM
						  INFORMATION_SCHEMA.KEY_COLUMN_USAGE
		 				WHERE
		 				  CONSTRAINT_SCHEMA=? AND TABLE_NAME = ?",
		 				  [$db_name,$table_name]);

		foreach ($outgoing_references as $ref)
		{
			if($ref->REFERENCED_TABLE_NAME)
			{
				$col=$this->col($ref->COLUMN_NAME);
				$col->references_table_name=$ref->REFERENCED_TABLE_NAME;
				$col->references_col_name=$ref->REFERENCED_COLUMN_NAME;
				if($expand_ref)
				{
					$col->references_table=ref($this->db->table($ref->REFERENCED_TABLE_NAME,TRUE));
					$col->references_col=ref($col->references_table->col($ref->REFERENCED_COLUMN_NAME));
				}
				array_push($this->outgoing_references,ref($col));
			}
		}

		if(0 && $expand_ref)
		{
			$incoming_references=data_db()->select("SELECT 
			 				  COLUMN_NAME,TABLE_NAME,REFERENCED_COLUMN_NAME,COLUMN_NAME
			 				FROM
							  INFORMATION_SCHEMA.KEY_COLUMN_USAGE
			 				WHERE
			 				  CONSTRAINT_SCHEMA=? AND REFERENCED_TABLE_NAME = ?",
			 				  [$db_name,$table_name]);

			foreach ($incoming_references as $ref)
			{
				$iref=new \stdClass;//IncomingReference;
				$iref->src_table_name=$ref->TABLE_NAME;
				$iref->src_col_name=$ref->COLUMN_NAME;
				$iref->src_table=ref($this->db->table($ref->TABLE_NAME,TRUE));
				$iref->src_col=ref($iref->table->col($ref->COLUMN_NAME));

				$iref->target_col_name=$ref->TARGET_COLUMN_NAME;
				$iref->target_col=ref($this->col($ref->TARGET_COLUMN_NAME));
				array_push($this->incoming_references,ref($iref));
			}
		}
		return $this;
	}
}