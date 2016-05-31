<?php
namespace App\Http\Controllers;
use App\Models\Display\Database;
use App\Models\Page\Page;
use App\Models\File\UserGroup;
use \Input;

class PageGenerationController extends GeneralController
{
	function getCreate($table_name,$update_mode=FALSE)
	{
		$db=Database::import_or_new(NULL,$table_name);
		
		$table=$db->table($table_name);

		$page=Page::import_or_new_with($table_name,
			['db'=>$db,'base_table'=>$table]);
		$table=$page->table($table_name);
		$id=$table->col('id');

		$user_groups=UserGroup::all();
		return view('panel.generate',
			['table'=>$table, 'user_groups'=>$user_groups,'existing_page'=>$page,'update_mode'=>$update_mode
			 ]
		);
	}
	function getEdit($table_name)
	{
		return $this->getCreate($table_name,TRUE);
	}
	function postEdit($table_name)
	{
		return $this->postCreate($table_name,TRUE);
	}
	function postCreate($table_name,$update_mode=FALSE)
	{
		$getAction=$update_mode?"getEdit":"getCreate";
		
		$db=Database::import_or_new(NULL,$table_name);
		$table=$db->table($table_name);
	
		$page_name=Input::get('page_name');
		if(!$page_name)
			return redirect()->action("PageGenerationController@$getAction",[$table_name])->with(['message_type'=>'danger','message'=>'Page name must be given! This is generally the same as table name!']);

		$page=Page::import_or_new_with($page_name,
			['db'=>$db,'base_table'=>$table]);

		if(!$update_mode && $page->is_imported)
			return redirect()->action('PageGenerationController@getCreate',[$table_name])->with(['message_type'=>'danger','message'=>'Page already exists! Give a new name or open the same in <a href="'.action('PageGenerationController@getEdit',[$table_name]).'">edit mode</a>!']);
		$table=$page->table($table_name);
		$col_settings_all=Input::get('col')[$table_name];
		foreach ($col_settings_all as $col_name => $col_settings)
		{
			$col=$table->col($col_name);
			foreach ($col_settings as $key => $value)
			{
				$col->$key=$value;
			}
		}

		$page_settings_all=Input::get('page');
		$page->user_group_permissions("");

		if($page_settings_all)
			foreach ($page_settings_all as $key => $value)
			{
				$page->$key=$value;
			}
		$page->export();

		return redirect()->action("PageGenerationController@getEdit",[$table_name]);
	}
	function getCreateAll()
	{
		$db=Database::import_or_new(NULL);
		$tables = $db->tables;
		foreach ($tables as $table)
		{
			$page_name=$table->name;
			
			$page=Page::import_or_new_with($page_name,
			['db'=>$db,'base_table'=>$table]);
			if($page->is_imported)
				continue;
		
			$table=$page->table($table->name);
	
			$page->user_group_permissions("");
			
			$page->export();
		}

		return redirect()->action("TableController@getIndex")->with('message_type','success')
			->with('message','Success!');;
	}
}