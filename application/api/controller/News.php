<?php

namespace app\api\controller;
use app\api\model\News as NewsModel;
use app\api\model\User as UserModel;
use app\api\model\NewsCategories as NewsCategoriesModel;
use app\api\model\NewsComments as NewsCommentsModel;

use think\Controller;
use think\Request;
use think\Loader;
use think\Db;


class News extends Controller
{
    /**
     * 显示资源列表
     *
     * @param  int  $page
     * @param  int  $pagesize
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $cat_id = !is_null($request->param('cat_id')) ? $request->param('cat_id') : null;
        $page = !is_null($request->param('page')) ? $request->param('page') : 1;
        $pagesize = !is_null($request->param('pagesize')) ? $request->param('pagesize') : 10;

        //方法一：
        // $newsList = NewsModel::all();
        $newsList = NewsModel::all(function($query) use ( & $cat_id, $page, $pagesize) {
            if($cat_id){
                $query->page($page,$pagesize)->where('cat_id', $cat_id)->field('news_id,cat_id,img_id,news_title,news_souce,editor_id');
            }else{
                $query->page($page,$pagesize)->field('news_id,cat_id,img_id,news_title,news_souce,editor_id');
            }
        });
        foreach ($newsList as $key => $value) {
            $value->cate;
            $value->editor;
            $value->img;
        }

        //方法二：
        // $newslist = Db::name('news')->join('news_categories', 'news.cat_id = news_categories.cat_id')->join('news_images', 'news.img_id = news_images.img_id')->field('news_id,news_title,news_souce,news_author,news.cat_id,cat_name,news.img_id,news_images.img_thumbUrl,news_images.img_commonUrl')->select();     
        // return json($newslist);

        if($newsList){
            $result["data"] = $newsList;
            $result["status"] = true;
        }else{
            $result["errorMsg"] = "请求错误";
            $result["status"] = false;
        }

        return json($result);
    }


    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->param();

        $validate = Loader::validate('NewsValid');
        
        if(!$validate->check($data)){
            $result["errorMsg"] = $validate->getError();
            $result["status"] = false;
        }else{
            $createRst = NewsModel::create($data);
            if($createRst){
                $result["data"] = $createRst;
                $result["status"] = true;
            }else{
                $result["errorMsg"] = "添加错误";
                $result["status"] = false;
            }
        }
        return json($result);
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
        $news = NewsModel::get($id);
        if($news){
            $news->cate;
            $news->editor;
            $news->img;

            //数组方式查询
            // $comments = NewsCommentsModel::all(['news_id'=>$id]);
        
            //闭包方式查询
            $comments = NewsCommentsModel::all(function($query) use ( & $id) {
                $query->where('news_id', $id)->limit(3);
            });

            foreach ($comments as $key => $value) {
                $value->user;
            }
            $news['comments'] = $comments;


            $result = array(
                "data" => $news,
                "status" => true
            );
            return json($result);
        }else{
            $error = array("status" => false, "errorMsg" => "找不到指定的资讯");
            return json($error);
        }
    }


    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->param();

        $validate = Loader::validate('NewsValid');
        
        if(!$validate->check($data)){
            $result["errorMsg"] = $validate->getError();
            $result["status"] = false;
        }else{
            $updateRst = NewsModel::update($data, ['news_id' => $id]);
            if($updateRst){
                $result["data"] = $updateRst;
                $result["status"] = true;
            }else{
                $result["errorMsg"] = "新闻修改错误";
                $result["status"] = false;
            }
        }
        return json($result);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $deleteRst = NewsModel::destroy($id);
        if($deleteRst){
            $result["status"] = true;
        }else{
            $result["errorMsg"] = "删除不成功";
            $result["status"] = false;
        }
        return json($result);
    }
}
