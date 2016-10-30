<?php
namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        return 'api Index';
    }

    public function hello($name='ken'){
    	return 'hello ' . $name;
    }

    public function test($name='ken'){
    	return 'hello, ' . $name . ' , This is a test.';
    }

    public function today($year, $month){
        return '现在是' . $year . '年' . $month . '月'; 
    }

    public function funny(){
        return 'funny';
    }
}
