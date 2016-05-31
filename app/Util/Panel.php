<?php
namespace Util;
use \Config;
class Panel
{
	static $user_configs=[];
	static function basic_storage_type(&$settings=NULL)
	{
		$basic=Config::get('basic');
		$settings = $basic[$basic['save_in']];
		return $basic['save_in'];
	}
}