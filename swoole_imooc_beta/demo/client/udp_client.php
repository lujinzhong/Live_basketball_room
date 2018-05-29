<?php
  $client=new swoole_client(SWOOLE_SOCK_UDP);
  //connect
  if(!$client->connect("127.0.0.1",9502)){
  	echo "connect error\n";
  	exit;
  }

  fwrite(STDOUT, "input your name\n");
  $data=trim(fgets(STDIN));
  //send to the server
  $size=$client->send($data);
  if(!$size){
    echo $client->errCode();
  }
  //receive the message from the server
  $res=$client->recv();
  echo "form server:".$res."\n";

