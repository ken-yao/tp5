<?php

namespace app\api\controller;

use app\api\model\NewsComments as NewsCommentsModel;
use think\Controller;
use think\Request;
use think\Loader;

class Comment extends Controller
{
    /**
     * 显示资源列表
     *
     * @param  int  $id
     * @param  int  $page
     * @param  int  $pagesize
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $result = array();
        $id = !is_null($request->param('id')) ? $request->param('id') : null;
        $page = !is_null($request->param('page')) ? $request->param('page') : 1;
        $pagesize = !is_null($request->param('pagesize')) ? $request->param('pagesize') : 10;

        $commentsList = NewsCommentsModel::all(function($query) use ( & $id, $page, $pagesize) {
            if($id){
                $query->where('news_id', $id)->page($page,$pagesize)->field('comment_id,news_id,user_id,comment_content,comment_is_show,create_time,comment_good_count,comment_bad_count');
            }else{
                $query->page($page,$pagesize)->field('comment_id,news_id,user_id,comment_content,comment_is_show,create_time,comment_good_count,comment_bad_count');
            }
        });
        foreach ($commentsList as $key => $value) {
            $value->user;
        }

        if($commentsList){
            $result["data"] = $commentsList;
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
        //
        $data = $request->param();

        $validate = Loader::validate('NewsCommentValid');
        
        if(!$validate->check($data)){
            $result["errorMsg"] = $validate->getError();
            $result["status"] = false;
        }else{
            $createRst = NewsCommentsModel::create($data);

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
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $deleteRst = NewsCommentsModel::destroy($id);
        if($deleteRst){
            $result["status"] = true;
        }else{
            $result["errorMsg"] = "删除不成功";
            $result["status"] = false;
        }
        return json($result);
    }
}
