<?php

$res= swoole_async_readfile(__DIR__."/1.txt", function($filename,$content){
 	echo "filename:{$filename}".PHP_EOL;
 	echo "content:{$content}"; 

 });
var_dump($res);
echo __DIR__."1.txt";
echo PHP_EOL."niahoa ";
