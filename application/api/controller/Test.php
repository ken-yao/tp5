<?php
namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Db;

class Test extends Controller
{
    public function index()
    {
        return 'api test';
    }

    public function hello($name='ken'){
    	return 'hello ' . $name;
    }

    public function all(){
    	return 'all';
    }
}
