<?php
namespace app\common\validate;

use think\Validate;

class NewsCommentValid extends Validate
{
    protected $rule = [
        'news_id'  => 'require|number',
        'user_id' => 'require|number',
        'comment_content' => 'require',
    ];

}