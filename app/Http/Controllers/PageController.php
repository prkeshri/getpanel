<?php
namespace App\Http\Controllers;
use App\Models\Page\Page;
use App\Models\Display\Table as DisplayTable;
use \Input;
use \DB;
use \Auth;

class PageController extends GeneralController
{
	/*private $method_accessibility_map = array('getInsert' => '+',
		'postInsert' => '+',
		'getView' => '>',
		'getEdit' => '.',
		'postEdit' => '.',
		'getListMore' => '>');*/

	private function user_accessibility($page,$permission)
	{
		if(!$page->user_accessibility(Auth::user(),$permission))
			return redirect()->back()->with('message_type','danger')->with('message','Access Denied!');
	}
	function getInsert($page_name)
	{
		$page = unref(Page::import($page_name));
		if($r = $this->user_accessibility($page,'+')) return $r;

		return view('panel.data.page',['page'=>$page,'mode'=>'+']);	
	}
	function postInsert($page_name)
	{
		return $this->insert_or_update($page_name);
	}
	function insert_or_update($page_name,$mode='+')
	{
		$page = unref(Page::import($page_name));
		if($r = $this->user_accessibility($page,$mode)) return $r;

		$table_values=Input::get('v');
		
		if($mode=='.') $input_d_1 = Input::get('d');

		foreach ($table_values as $table_name => $values) 
		{
			$table = $page->table($table_name);
			$res = FALSE;
			foreach ($values as $col_name => $col_value)
			{
				if(isset($col_value['null']))
					$res1 = $table->col($col_name)->set_client_value($new_value = NULL);
				else
					$res1 = $table->col($col_name)->set_client_value($new_value = $col_value['value']);
				if(!$res) $res = $res1;

				if($mode=='.' && isset($input_d_1[$table_name][$col_name])) $input_d_1[$table_name][$col_name] = $new_value;
			}

			if($res)
			{
				if($mode=='+')
				{
					$res = $table->insert_from_client_values();
					if($res) return \Redirect::back()->with('message_type','success')->with('message','Successfully Saved!')->with('other_data',['opener_refresh'=>true]);
				}
				else if($mode=='.')
				{
					$input_d = Input::get('d');
					if(!$input_d[$table_name]) return view('panel.errors.5xx',['msg'=>'Table with no primary keys cannot be updated!']);
					$res = $table->update_from_client_values_and_edit_args($input_d[$table_name]);
					if($res) return \Redirect::away(action('PageController@getEdit',[$page_name]).'?'.http_build_query(['d'=>$input_d_1]))->with('message_type','success')->with('message','Successfully Saved!')->with('other_data',['opener_refresh'=>true]);
					else  return \Redirect::away(action('PageController@getEdit',[$page_name]).'?'.http_build_query(['d'=>$input_d_1]))->with('message_type','warning')->with('message','Nothing to save!');
				}
			}
			else
			{
				return \Redirect::back()->with('message_type','warning')->with('message','Nothing to save!');
			}
			
			return \Redirect::back()->with('message_type','danger')->with('message','Cannot Save! Some error has occurred!');
		}
	}

	function getView($page_name)
	{
		$page = unref(Page::import($page_name));
		if($r = $this->user_accessibility($page,'>')) return $r;

		$cols = $page->base_table->cols();
		$offset=Input::get('offset');
		$limit=Input::get('limit');
		if(!$offset) $offset=0;
		if(!$limit) $limit=20;
		$table_name=$page->base_table->name;
		$data=DB::table(DB::raw($table_name))->take($limit)->skip($offset)->get();
		foreach ($data as $datum)
		{
			$x='';
			foreach ($page->base_table->primary_cols as $col)
			{
				$col_name=$col->name;
				$x.='d['.urlencode($table_name).']['.urlencode($col_name).']='.urlencode($datum->$col_name).'&';
			}
			$datum->edit_args=$x;
		}

		return view('panel.data.list',['cols'=>$cols,'data'=>$data,'page'=>$page,'table'=>$page->base_table,'has_more'=>count($data)>19,'current_offset'=>$offset,'can_edit'=>$page->user_accessibility(Auth::user(),'.'),'can_insert'=>$page->user_accessibility(Auth::user(),'+')]);
	}
	function getEdit($page_name)
	{
		$page = unref(Page::import($page_name));
		if($r = $this->user_accessibility($page,'.')) return $r;

		$table = $page->base_table;
		$table_name = $table->name;

		if(!$page) return view('panel.errors.404');
		if(!Input::get('d')[$table_name]) return view('panel.errors.5xx',['msg'=>'Table with no primary keys cannot be updated!']);

		$datum = DB::table(DB::raw($page->base_table->name))->where(Input::get('d')[$table_name])->first();
		if(!$datum) return view('panel.errors.404');
		foreach ((array)$datum as $key => $value)
		{
			$table->col($key)->set_client_value_force($value);
		}
		return view('panel.data.page',['page'=>$page,'mode'=>'.']);	
	}
	function postEdit($page_name)
	{
		return $this->insert_or_update($page_name,'.');
	}
	function getListMore($page_name)
	{
		$page = unref(Page::import($page_name));
		if($r = $this->user_accessibility($page,'>')) return $r;
		
		$table_name = Input::get('table');
		$col = Input::get('col');
		$offset = Input::get('offset');

		$list_values=DisplayTable::import($table_name)->select_list_values($col,20,$offset);
		$next_query = NULL;
		if(count($list_values)==20)
		{
			$all=Input::all();
			$all['offset'] = intval($all['offset']) + 20;
			$next_query = http_build_query($all);
		}
		return view('panel.data.list-more-values',['list_values'=>$list_values,
			'next_query'=>$next_query]);
	}
}