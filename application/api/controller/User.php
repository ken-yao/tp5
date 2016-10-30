<?php

namespace app\api\controller;
use app\api\model\User as UserModel;
use app\api\model\Admin as AdminModel;

use think\Controller;
use think\Request;
use think\Loader;

use think\Db;


class User extends Controller
{
    protected function generate_token( $length = 32 ){
        $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',  
            'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',  
            't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D',  
            'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',  
            'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',  
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $keys = array_rand($chars, $length);  
        $token = '';  
        for($i = 0; $i < $length; $i++)  
        {  
            // 将 $length 个数组元素连接成字符串  
            $token .= $chars[$keys[$i]];  
        }  
        return $token;
    }

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
        $page = !is_null($request->param('page')) ? $request->param('page') : 1;
        $pagesize = !is_null($request->param('pagesize')) ? $request->param('pagesize') : 10;

        $userList = UserModel::all(function($query) use ( & $page, $pagesize) {
            $query->page($page,$pagesize)->field('user_id,user_name,user_sex,user_email,user_birthday,user_mobile,user_headpic,user_nickname,user_level,create_time,user_last_login,user_islock,user_email_validated,user_address_id');
        });
        foreach ($userList as $key => $value) {
            // 获取默认地址
            // $value->defaultAddress;
        }

        if($userList){
            $result["data"] = $userList;
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

        //检查手机号码是否存在
        $isMobileExist = UserModel::where('user_mobile', $data['user_mobile'])->find();

        if($isMobileExist){
            $result["errorMsg"] = "手机号码已存在";
            $result["status"] = false;
        }else{
            $validate = Loader::validate('UserValid');
            
            if(!$validate->check($data)){
                $result["errorMsg"] = $validate->getError();
                $result["status"] = false;
            }else{
                //加密密码
                $data['user_password'] = md5($data['user_password']);

                $createRst = UserModel::create($data);
                if($createRst){
                    $result["data"] = $createRst;
                    $result["status"] = true;
                }else{
                    $result["errorMsg"] = "添加错误";
                    $result["status"] = false;
                }
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
        $user = UserModel::get(function($query) use ( & $id){
            $query->where('user_id', $id)->field('user_id,user_name,user_sex,user_email,user_birthday,user_mobile,user_qq,user_headpic,user_nickname,user_level,user_discount,user_token,create_time,user_last_login,user_islock,user_email_validated,user_address_id');
        });

        if($user){
            // 获取默认地址
            // $value->defaultAddress;

            $result = array(
                "data" => $user,
                "status" => true
            );
            return json($result);
        }else{
            $error = array("status" => false, "errorMsg" => "登录失败");
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

    /**
     * 用户登录
     *
     * @param  string  $user_name
     * @param  string  $user_password
     * @return \think\Response
     */
    public function login(Request $request){

        $userinfo = $request->param();
        if(isset($userinfo['user_name']) && isset($userinfo['user_password'])){

            $user = UserModel::get(function($query) use ( & $userinfo){
                $query->where(['user_name' => $userinfo['user_name'], 'user_password' => md5($userinfo['user_password'])])->field('user_id,user_name,user_sex,user_email,user_birthday,user_mobile,user_qq,user_headpic,user_nickname,user_level,user_discount,user_token,create_time,user_last_login,user_islock,user_email_validated,user_address_id');
            });

            if($user){
                //用户登录成功，更新用户部分信息
                $user_token = $this->generate_token();
                $user_last_login = time();

                $updateRst = UserModel::where('user_id', $user['user_id'])->update(['user_token' => $user_token, 'user_last_login' => $user_last_login]);
                
                $user['user_token'] = $user_token;
                $user['user_last_login'] = $user_last_login;

                $result["data"] = $user;
                $result["status"] = true;
            }else{
                $result["errorMsg"] = "用户名或密码不正确";
                $result["status"] = false;
            }


        }else{
            $result["errorMsg"] = "用户名或密码为空";
            $result["status"] = false;
        }

        return json($result);

        
    }
}
