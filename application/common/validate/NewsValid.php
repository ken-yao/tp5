<?php
namespace app\common\validate;

use think\Validate;

class NewsValid extends Validate
{
    protected $rule = [
        'cat_id'  => 'require|number',
        'editor_id'  => 'require|number',
        'news_title' => 'require',
        'news_content' => 'require',
    ];

}