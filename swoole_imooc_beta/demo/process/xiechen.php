<?php

	$http=new swoole_http_server('127.0.0.1',9501);
    
	$http->on('request',function($request,$response){
		//use xiechen
		$redis=new Swoole\Coroutine\Redis();
		$redis->connect('127.0.0.1',6379);
	
		$value=$redis->get($request->get['a']);

		$response->header("Content-Type","text/plain");
		$response->end($value);
	});
	$http->start();