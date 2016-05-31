<?php
return array(
	'save_in'=>'folder',
	'database'=> array(
			'connection'=>array('driver'    => 'mysql',
		            'host'      => 'localhost',
		            'database'  => 'my_database_2',
		            'username'  => 'root',
		            'password'  => 'root',
		            'charset'   => 'utf8',
		            'collation' => 'utf8_unicode_ci',
		            'prefix'    => '',
		            'strict'    => false),
			'connection_key'=>'panel_st',
			'table'=>'new_table'
			),
	'folder'=> array(
			'path' => storage_path('panel/serialize'),
		   	'filesystem_key'=>'panel_st'
	  		),
);