<?php
namespace App\Models\Page;
use App\Util\TableBuilder\UI_With_Custom;
trait InnerAccess
{
	public $containee, //One which is contained. This is ALWAYS the default one!
		$use_custom_values=[];
	protected $__no_further_export=['containee'];
	/*
		The Get and Set will have my Values.
		If custom values not used, then I will show from my $containee
		//col[id][use_custom][var] => true/false
	*/
	function use_custom($arr)
	{
		foreach ($arr as $key => $val)
		{
			to_bool($val);
			$this->use_custom_values[$key]=$val;
		}
	}
	function extra_config_options($name_prefix,$ui=NULL)
	{ 
		$ui=UI_With_Custom::with_name_prefix($name_prefix,'[use_custom]',$this);
		return parent::extra_config_options($name_prefix,$ui);
	}
	function final_value($var)
	{	
		if(@$this->use_custom_values[$var] || !$this->containee)
			return $this->$var;
		else
			return $this->containee->$var;
	}
}