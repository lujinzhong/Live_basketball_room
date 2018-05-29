<?php

  /**
   * redis config 
   */

  return [
  	 'host' => "127.0.0.1",
  	 'port' =>6379,
  	 'out_time'=>3600,
  	 'timeOut'=>5,  //connect timeout 
  	 'live_game_fd'=>'live_game_fd',//客户端fd有序列表前缀
  ];