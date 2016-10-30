<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::rule('funny','api/Index/funny');

Route::resource('api/news','api/news');
Route::resource('api/comment','api/comment');
Route::resource('api/user','api/user');

Route::rule('api/users/login','api/user/login');
Route::rule('api/users/register','api/user/save', 'POST');



// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],

//     '[hello]'     => [
//     	'' => ['index/all', ['method' => 'get']],
//         // ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello/:name', ['method' => 'get']],
//     ],

//     //下面的参数:name用中括号括起来表示此参数可传可不传
//     // 'test/[:name]' => ['api/index/test', ['method' => 'get', 'ext' => 'html']],
//     'test/[:name]' => ['api/index/test', ['method' => 'get']],

//     'today/:year/:month' => ['api/index/today', ['method' => 'get'], ['year' => '\d{4}', 'month' => '\d{2}']],


//     '[news]'


// ];

