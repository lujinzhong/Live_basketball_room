<?php
//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("127.0.0.1", 9501); 

$arr=array(
	"worker_num"=>4,
	"max_request"=>10000
	);
$serv->set($arr);

//监听连接进入事件
$serv->on('connect', function ($serv, $fd,$reactor_id) {  
    echo "Client:Connect-fd:{$fd}-reactor:{$reactor_id}\n";
});

//监听数据接收事件
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "Server:fd:{$fd}--from_id:{$from_id} ".$data);
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start(); 



