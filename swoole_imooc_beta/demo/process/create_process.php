<?php

	$process=new swoole_process(function(swoole_process $pro){
    
    $pro->exec('/home/xiaolu/php/bin/php',[__DIR__."/../server/http.php"]);


	},false);
	$pid=$process->start();
	echo $pid.PHP_EOL;
	//huishou
	swoole_process::wait();