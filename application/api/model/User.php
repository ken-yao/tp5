<?php
namespace app\api\model;

use think\Model;

class User extends Model{
    protected $autoWriteTimestamp = true;
    protected $insert             = [
        'user_islock' => 0
    ];

    protected $field = [
        'user_id'          => 'int',
        'user_sex'      => 'int',
        'user_birthday'      => 'int',
        'user_province'      => 'int',
        'user_city'      => 'int',
        'user_district'      => 'int',
        'user_address_id'      => 'int',
        'user_level'      => 'int',
        'user_discount'      => 'float',
        'user_money'      => 'float',
        'user_frozen_money'      => 'float',
        'user_last_login'      => 'int',
        'user_islock'      => 'int',
        'user_email_validated'      => 'int',
        'user_pay_points'      => 'int',
        'create_time'      => 'int',
        'update_time'      => 'int',
        'user_password','user_name','user_email','user_mobile','user_qq','user_headpic','user_nickname','user_token','user_last_ip','user_oauth','user_openid',
    ];


}