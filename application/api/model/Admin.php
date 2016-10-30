<?php
namespace app\api\model;

use think\Model;

class Admin extends Model{
    protected $autoWriteTimestamp = true;

    protected $insert             = [
        'admin_roleid' => 0,
    ];

    protected $field = [
        'admin_id'          => 'int',
        'admin_roleid'      => 'int',
        'admin_last_login'      => 'int',
        'create_time'      => 'int',
        'update_time'      => 'int',
        'admin_name','admin_email','admin_password','admin_token','admin_login_ip','admin_right','admin_mobile','admin_headpic','admin_nickname'
    ];


}