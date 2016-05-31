<?php
namespace App\Util;

class Dumper
{
	static function call_methods($obj)
	{
		echo '<pre>';
		echo 'Dumping '.get_class($obj).'<hr/>';
		$methods = get_class_methods($obj);
		foreach ($methods as $method)
		{
			if(substr($method, 0 ,2)==='__') continue;
			echo "\t\t\t\t\t<b>Method:</b> " . $method.'<br/>';
			$r = new \ReflectionMethod($obj, $method);
			$params = $r->getParameters();
			if(count($params)>0)
			{
				if(!$params[0]->isOptional())
				{	
					echo "---Params needed---!\n";
					continue;
				}
			}
			try
			{
				($obj->$method());
			} catch (Throwable $e) {
				echo 'Exception '.$e->getMessage();
			}
		}
		die;
	}
}
