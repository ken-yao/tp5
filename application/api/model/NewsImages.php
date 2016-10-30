<?php
namespace app\api\model;

use think\Model;

class NewsImages extends Model{
    protected $autoWriteTimestamp = true;

    protected $field = [
        'img_id'          => 'int',
        'img_thumbWidth'      => 'int',
        'img_thumbHeight'      => 'int',
        'img_commonWidth'      => 'int',
        'img_commonHeight'      => 'int',
        'img_originWidth'      => 'int',
        'img_originHeight'      => 'int',
        'news_publish_time'      => 'int',
        'create_time'      => 'int',
        'update_time'      => 'int',
        'img_title', 'img_thumbUrl', 'img_commonUrl', 'img_originUrl'
    ];

}