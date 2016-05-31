<?php
namespace App\Http\Controllers;
use App\Models\Display\Database;
use App\Models\Page\Page;
use App\Models\MiscellaneousSetting;
use \Input;
class TableController extends GeneralController
{
	function getIndex()
	{	
		$db=Database::import_or_new();
		$db->export();
		$tables=$db->tables();
		if(!$db->is_imported) $db->export();

		return view('panel.tables',
			['tables'=>$tables]
		);
	}
	function postIndex()
	{
		$db=Database::import();
		foreach (Input::get('display') as $table_name => $display_settings)
		{
			$table=$db->table($table_name);
			foreach ($display_settings as $key => $value) {
				$table->display($key,$value);
			}
		}

		$db->export();
		return redirect()->back();
	}

	function getSet($table_name)
	{
		$db=Database::import_or_new(NULL,$table_name);
		$table=$db->table($table_name);
		$table->export();###
		return view('panel.table_setting',
			['table'=>$table]
		);
	}

	function postSet($table_name)
	{
		$table=Database::import_or_new()->table($table_name);
		foreach (Input::get('col')[$table_name] as $col_name => $col_settings)
		{
			$col=$table->col($col_name);
			foreach ($col_settings as $key => $value)
			{
				$col->$key=$value;
			}
		}

		$table->export();
		return redirect()->action('TableController@getSet',['t'=>$table_name]);
	}

	function getMiscellaneous()
	{
		$setting = MiscellaneousSetting::i();
		return view('panel.table_miscellaneous',['setting'=>$setting->setting]);
	}

	function postMiscellaneous()
	{
		$setting = Input::get('setting');

		MiscellaneousSetting::i()->setting=to_bool_recursive($setting);
		MiscellaneousSetting::i()->export();
		return redirect()->action('TableController@getMiscellaneous');
	}
}
