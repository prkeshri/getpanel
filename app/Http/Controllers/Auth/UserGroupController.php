<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\GeneralController;
use App\Models\File\UserGroup;
use \Input;
class UserGroupController extends GeneralController
{
	function getIndex()
	{
		$user_groups = UserGroup::all();
		return view('panel.users.groups',['user_groups'=>$user_groups]);
	}
	function postIndex()
	{
		$data = Input::get("user_group");

		if(empty($data['id']))
		{
			$data['id']=count(UserGroup::all())+1;
			UserGroup::create($data)->export();
		}
		else
		{
			$ug = UserGroup::import_by_id($data['id']);
			foreach ($data as $key => $value) {
				$ug->$key=$value;
			}
			$ug->export();
		}
		return \Redirect::back()->with('message_type','success')->with('message','Success!');
	}
}