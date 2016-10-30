<?php
namespace app\api\model;

use think\Model;

class News extends Model{
    protected $autoWriteTimestamp = true;
    protected $insert             = [
        'news_type' => 1,
        'news_isopen' => 1,
    ];

    protected $field = [
        'news_id'          => 'int',
        'cat_id'      => 'int',
        'news_type'      => 'int',
        'news_isopen'      => 'int',
        'img_id'      => 'int',
        'editor_id'      => 'int',
        'news_isrecommend'      => 'int',
        'news_hits'      => 'int',
        'news_publish_time'      => 'int',
        'news_good_count'      => 'int',
        'news_bad_count'      => 'int',
        'create_time'      => 'int',
        'update_time'      => 'int',
        'news_title', 'news_description', 'news_keywords', 'news_content', 'news_souce', 'news_soucelink', 'news_file_url'
    ];

    public function cate(){
        return $this->hasOne('NewsCategories',"cat_id","cat_id")->field('cat_id,cat_name');
    }

    public function editor(){
        return $this->hasOne('Admin',"admin_id", "editor_id")->field('admin_id,admin_nickname,admin_email,admin_headpic');
    }

    public function img(){
        return $this->hasOne('NewsImages',"img_id","img_id")->field('img_id,img_title,img_thumbUrl,img_commonUrl,img_originUrl');
    }

    public function comment(){
        return $this->hasMany('NewsComments',"news_id","news_id")->field('comment_id,news_id,user_id,comment_content,comment_is_show,create_time,comment_good_count,comment_bad_count');
    }

}