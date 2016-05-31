<?php

namespace App\Models;

class MiscellaneousSetting extends BaseModel
{
	use SingletonTrait;
	static $config_prefix='ms_miscel';
	protected $name=''; //Always!

	public $setting;
}