<?php

	$redis_client=new swoole_redis();
	$redis_client->connect('127.0.0.1',6379,function($redis_client,$result){
		if($result == false){
			//connect error
			var_dump($redis_client->errCode).PHP_EOL;
			var_dump($redis_client->errMsg).PHP_EOL;
			die;

		}
		echo "connect success".PHP_EOL;
		//set 
		/*$redis_client->set('name','xiaolu',function($redis_client,$result){
			if($result === false){
				var_dump($redis_client->errCode).PHP_EOL;
			    var_dump($redis_client->errMsg).PHP_EOL;
			}
			echo "set success".PHP_EOL;
			var_dump($result);
			$redis_client->close();
			
		});*/
		//get
		$redis_client->get('user',function($redis_client,$result){
			if($result === false){
				var_dump($redis_client->errCode).PHP_EOL;
				var_dump($redis_client->errMsg).PHP_EOL;
			}
			echo "get success".PHP_EOL;
			var_dump($result);
			$redis_client->close();


		});



	});
	echo "start".PHP_EOL;