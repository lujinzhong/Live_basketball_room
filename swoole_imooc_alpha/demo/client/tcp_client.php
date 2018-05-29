<?php
  //tcp connect
  $client=new swoole_client(SWOOLE_SOCK_TCP);

  //connect
  if(!$client->connect("127.0.0.1",9501)){
  	echo "connect error";
  	exit; 
  }
  fwrite(STDOUT, "input some thing?\n");
  //jiehsou
  $msg=trim(fgets(STDIN));

  //send to server
  $client->send($msg);

  //receive form server
  $result=$client->recv();
  if($result){
  	echo $result."\n";
  }
