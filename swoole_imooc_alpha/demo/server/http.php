<?php

 $http = new swoole_http_server("127.0.0.1", 9501);


 $http->set([
    'enable_static_handler' => true,
    'document_root' =>"/home/xiaolu/web/swoole_imooc/html",
]);

 $http->on('request', function ($request, $response) {

    $content=[
    	"data:"=>date("Y-m-d H:i:s"),
    	"get:"=>$request->get,
    	"post:"=>$request->post,
    	"header:"=>$request->header,
    ];
   swoole_async_writefile('write.log', json_encode($content).PHP_EOL, function($filename) {
    //todo
}, FILE_APPEND); 
 	$response->cookie("name","xiaolu",time()+320);
    $response->end("get".json_encode($request->get));
});
$http->start();