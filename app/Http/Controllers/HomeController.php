<?php
namespace App\Http\Controllers;

use App\Models\Display\Database;
use App\Models\Page\Page;
use \Input;
use \Config;
use \Auth;

class HomeController extends GeneralController
{
	function getIndex()
	{
		$pages = Page::all();
		$user=Auth::user();
		$users = $user_groups = ($user->type===0);
		return view('panel.intro',['pages'=>Page::all(),'user' => Auth::user(),'user_groups'=>$user_groups, 'users'=>$users
			]);
	}
	function getStep2()
	{
		return view("panel.intro-2",array('basic'=>Config::get("basic")));
	}
	function getHome()
	{
		return $this->getIndex();
	}
}