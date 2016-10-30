<?php
namespace app\api\model;

use think\Model;

class NewsCategories extends Model{
    protected $autoWriteTimestamp = true;
    protected $insert             = [
        'news_type' => 1,
    ];

    protected $field = [
        'cat_id'          => 'int',
        'cat_group'      => 'int',
        'parent_id'      => 'int',
        'type'      => 'int',
        'cat_name'
    ];


    // public function getCateName(){
    //     return $this->cat_name;
    // }

}