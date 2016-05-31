<?php

namespace App\Models\File;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends \App\Models\BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authorizable, CanResetPassword;

    static $config_prefix='user_',$PermanentStorageKey='id';
    
    public $id,$name,$email,$password,$remember_token,$created_at,$updated_at,$type,$user_groups=[];
    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->{$this->getRememberTokenName()};
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->{$this->getRememberTokenName()}=$value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    static function create($arr)
    {
        $arr['id']=md5($arr['email']);
        if(static::count()==0)
        {
            $arr['type']=0;
            static::first_user_tasks($arr);
        }
        else
            $arr['type']=1;
        $user = parent::create($arr);
        $user->export();
        return $user;
    }
    static function first_user_tasks(&$arr)
    {
        $user_group=UserGroup::create(array('id'=>1,'name'=>'master_admin','parent_group_id'=>NULL,'description'=>'Master Administrator'));
        $user_group->export();

        $arr['user_groups'][$user_group->id]=[ref($user_group)];
    }
}
