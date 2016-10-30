<?php
namespace app\index\controller;

use app\api\model\News as NewsModel;

use think\Controller;
use think\Request;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        // print_r($this->request->param());
        // $data = Db::name('user')->find();
        // print_r($data);

        //查询方法一：
        $newslist = Db::name('news')->join('news_categories', 'news.cat_id = news_categories.cat_id')->field('news_id,cat_name,news_title,news_souce,editor_id')->select();

        //查询方法二：此方法使用Model，拼接关联的模型，获取结果稍有不同
        // $newslist = NewsModel::all();
        // foreach ($newslist as $key => $value) {
        //     $value->cate;
        // }

        $this->assign('newslist', $newslist);
        return $this->fetch();
    }

    public function newsinfo(){
        $id = $this->request->param('id');
        if($id){
            $newsinfo = Db::name('news')->join('news_categories', 'news.cat_id = news_categories.cat_id')->field('news_id, news_title, cat_name, news_keywords, news_description, news_content, news_type, news_souce, news_soucelink, news_file_url, editor_id, news_hits, news_publish_time, news_good_count, news_bad_count, news_isrecommend')->find($id);

            $newsinfo['news_publish_time'] = date('Y-m-d H:i:s', $newsinfo['news_publish_time']);

            $this->assign('newsinfo', $newsinfo);

            return $this->fetch();
        }else{
            echo '请求有误';
        }
    }
}
