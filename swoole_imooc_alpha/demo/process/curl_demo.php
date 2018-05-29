<?php
    //output the start time
	echo "start time:".date("Y-m-d H:i:s",time()).PHP_EOL;
	$worker=[];
	$urls=[
	 "http://www.baidu.com",
	 "http://www.sina.com",
	 "http://mclink.xyz",
	 "http://www.taobao.com",
	 "http://www.jingdong.com",
	 "http://www.yahu.ocm",

	];

	for ($i=0; $i <6 ; $i++) { 
      $process=new swoole_process(function(swoole_process $worker)use($i,$urls){

      $content=curl_request($urls[$i]);
      //write in pipe
      $worker->write($content.PHP_EOL);

		     
      },true);
      
     $pid=$process->start();
     echo $pid.PHP_EOL;
     $worker[$pid]=$process;
	}
     //output datas in pipe
	 foreach ($worker as $process) {
      	# code...
       echo $process->read();
      }
   
   function curl_request($url){
   	sleep(2);
   	return $url."success".PHP_EOL;
   	
   }
   

   //output end time
	echo "end time:".date("Y-m-d H:i:s",time()).PHP_EOL;

     swoole_process::wait();