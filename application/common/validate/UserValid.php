<?php
namespace app\common\validate;

use think\Validate;

class UserValid extends Validate
{
    protected $rule = [
        'user_password'  => 'require',
        'user_name'  => 'require',
        'user_mobile' => 'require'
    ];

}