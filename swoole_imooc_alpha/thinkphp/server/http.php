<?php

 $http = new swoole_http_server("127.0.0.1", 9501);


 $http->set([
    'enable_static_handler' => true,
    'document_root' =>__DIR__."/../public/static",
    'worker_num'=>5,
]);

$http->on('WorkerStart', function(swoole_server $server,  $worker_id) {
      // 定义应用目录
      define('APP_PATH', __DIR__ . '/../application/');
      // ThinkPHP 引导文件
      // 加载基础文件
      require __DIR__ . '/../thinkphp/base.php';
});
 
     /**
     * 解决上一次输入的变量还存在的问题
     * 方案一：if(!empty($_GET)) {unset($_GET);}
     * 方案二：$http-close();把之前的进程kill，swoole会重新启一个进程，重启会释放内存，把上一次的资源包括变量等全部清空
     * 方案三：$_SERVER  =  []
     */

 $http->on('request', function ($request, $response)use($http) {

 	 $_SERVER  =  [];
    //server
    if(isset($request->server)) {
        foreach($request->server as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    //header
    if(isset($request->header)) {
        foreach($request->header as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    //get
    $_GET = [];
    if(isset($request->get)) {
        foreach($request->get as $k => $v) {
            $_GET[$k] = $v;
        }
    }
    //post
    $_POST = [];
    if(isset($request->post)) {
        foreach($request->post as $k => $v) {
            $_POST[$k] = $v;
        }
    }
    //开启缓冲区
    ob_start();
    // 执行应用并响应
    try {
        think\Container::get('app', [APP_PATH])
            ->run()
            ->send();
    }catch (\Exception $e) {
        // todo
    }
    //输出TP当前请求的控制方法
    //echo "-action-".request()->action().PHP_EOL;
    //获取缓冲区内容
    $res = ob_get_contents();
    ob_end_clean();

    // $response->header("Content-Type","text/html");
    $response->header("charset","utf-8");
    $response->end($res);
    //把之前的进程kill，swoole会重新启一个进程，重启会释放内存，把上一次的资源包括变量等全部清空
    //$http->close();
    

});
$http->start();