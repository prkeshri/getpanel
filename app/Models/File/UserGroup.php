<?php

namespace App\Models\File;
class UserGroup extends \App\Models\BaseModel
{
	static $config_prefix='usergroup_',$PermanentStorageKey='id';
	public $id,$name,$parent_group_id,$description;
}