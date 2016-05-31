<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\GeneralController;
use App\Models\File\User;
use App\Models\File\UserGroup;
use \Input;
use \Auth;
class UserController extends GeneralController
{
	function getIndex()
	{
		$users = User::all();
		return view('panel.users.list',['users'=>$users]);
	}
	function postDelete()
	{
		$id = @Input::get('user')['id'];
		if(!$id) return;
		return \Redirect::back()->with('message_type','warning')->with('message','Deletion not implemented currently!');
	}
    public function getEdit($id)
    {
        $arr = ['update_mode'=>true];
        $arr['user_groups'] = UserGroup::all();
        $arr['user'] = User::import_by_id($id);
        return view('panel.users.edit',$arr);
    } 
    public function postEdit($id)
    {
    	$iuser = Input::get('user');
    	$user = User::find($id);
    	if(@$iuser['user_groups'])
    	{
    		$new_set = [];

    		foreach ($iuser['user_groups'] as $key => $value) {
    			$new_set[$key]=ref(UserGroup::find($key));
    		}
    		if($user->type===0) $new_set[1]=ref(UserGroup::find(1));
    		$iuser['user_groups'] = $new_set;
    	}

    	foreach ($iuser as $key => $value) {
    		$user->$key=$value;
    	}
    	$user->export();
    	return\Redirect::back()->with('message_type','success')->with('message','Success!');
    }
}