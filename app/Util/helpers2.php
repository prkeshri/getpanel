<?php
/*
	Map the commonly used methods
*/
	require_once(__DIR__.'/Panel.php');
use Util\Panel;
	function user_config_find($prefix='',$id)
	{

		global $user_configs;
		$save_in=Panel::basic_storage_type($settings);
		if($save_in==='folder')
		{
			$path=$settings['path'];
			$di=new DirectoryIterator($path);
			foreach ($di as $key => $value)
			{	
				$path=$value->getPathName();
				$file_name=$value->getFileName();
				if($prefix && substr_compare($file_name, $prefix, 0,strlen($prefix))!==0)
					continue;
				$fps = explode('@', $file_name);
				if(count($fps)>1) continue;
				$key_extn = substr($file_name, strlen($prefix));
				$key=implode('.', explode('.', $key_extn,-1));
				if($key==$id) return @include($path);
			}
			return NULL;
		}
		else if($save_in==='database')
		{
			$config_table=$settings['table'];
			$conf=admin_db("SELECT `key`,`val` FROM $config_table WHERE `key` LIKE ? AND `key` NOT LIKE '%@%'",[implode('\\_', explode('_', $prefix)).'%']);
			if(!$conf) return NULL;
			return json_decode($conf[0]->val,TRUE);
		}
		else
			throw new Exception("Invalid Configuration!", 1);
	}
	
	function user_config_all($prefix='',$return_key_array=FALSE)
	{

		global $user_configs;
		$save_in=Panel::basic_storage_type($settings);
		if($save_in==='folder')
		{
			$path=$settings['path'];
			$di=new DirectoryIterator($path);
			$ret_confs=[];
			foreach ($di as $key => $value)
			{	
				$path=$value->getPathName();
				$file_name=$value->getFileName();
				if($prefix && substr_compare($file_name, $prefix, 0,strlen($prefix))!==0)
					continue;
				$fps = explode('@', $file_name);
				if(count($fps)>1) continue;

				$key=implode('.', explode('.', $file_name,-1));
				if($return_key_array) $ret_confs[]=$key;
				else $ret_confs[$key]=$user_configs[$key]=@include($path);
			}
		}
		else if($save_in==='database')
		{
			$config_table=$settings['table'];
			$conf=admin_db("SELECT `key`,`val` FROM $config_table WHERE `key` LIKE ? AND `key` NOT LIKE '%@%'",[implode('\\_', explode('_', $prefix)).'%']);
			if(!$conf) return [];
			$ret_confs=[];
			foreach ($conf as $cf)
			{
				$ret_confs[$cf->key]=$user_configs[$cf->key]=json_decode($cf->val,TRUE);
			}
		}
		else
			throw new Exception("Invalid Configuration!", 1);
		return $ret_confs;
	}
	function user_config($c,$def=NULL) //Writable configs!
	{
		global $user_configs;
		$cs=explode('.', $c);
		$config_file=array_shift($cs);
		if(@$user_configs[$config_file])
			return $user_configs[$config_file];

		$save_in=Panel::basic_storage_type($settings);
		if($save_in==='folder')
		{
			$path=$settings['path'];
			$conf=@include($path.DIRECTORY_SEPARATOR.$config_file.'.php');
			if(!$conf) return $def;
		}
		else if($save_in==='database')
		{
			$config_table=$settings['table'];
			$conf=head(admin_db("SELECT `val` FROM $config_table WHERE `key`=?",[$config_file]));
			if(!$conf) return NULL;
			$conf=json_decode($conf->val,TRUE);
		}
		else
			throw new Exception("Invalid Configuration!", 1);
			
		$user_configs[$config_file]=$conf;

		$c=implode('.', $cs);
		if(!$c) return $conf;
		else return array_get($conf,$c);
	}
	function user_config_replace_values($config_file,$vals)
	{
		global $user_configs;
		foreach ($vals as $key => $value)
		{
			$user_configs[$config_file][$key]=$value;
		}
	}
	function user_config_replace($config_file,$v)
	{
		global $user_configs;
		$user_configs[$config_file]=$v;
	}
	function user_config_save($config_file,$replace=NULL)
	{
		global $user_configs;
		if($replace)
			user_config_replace_values($config_file,$replace);
		else if(!@$user_configs[$config_file])
			return;

		$save_in=Panel::basic_storage_type($settings);
		if($save_in==='folder')
		{
			$content='<?php return '.var_export($user_configs[$config_file],true).';';
			Storage::disk($settings['filesystem_key'])->put($config_file.'.php',$content);
		}
		else if($save_in==='database')
		{
			$config_table=$settings['table'];
			admin_db()->insert("INSERT INTO $config_table(`key`,`val`)
				VALUES(?,?)
				ON DUPLICATE KEY UPDATE `val`=VALUES(`val`)",[$config_file,
				json_encode($user_configs[$config_file])]);
		}
		else
			throw new Exception("Invalid Configuration!", 1);
	}
	function data_db_name()
	{
		return Config::get('database.connections.'.Config::get('database.default').'.database');
	}
	function data_db()
	{
		return DB::connection(Config::get('database.default'));
	}
	function admin_connection_name()
	{
		return Config::get('basic.database.connection_key');
	}
	function admin_db()
	{
		$db = DB::connection(Config::get('basic.database.connection_key'));
		if(count(func_get_args())>0) return call_user_func_array([$db,'select'], func_get_args());
		return $db;
	}