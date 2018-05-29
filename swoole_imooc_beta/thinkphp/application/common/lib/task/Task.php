<?php
 namespace app\common\lib\task;

use app\common\lib\redis\Predis;
use app\common\lib\Redis;
use app\common\lib\ali\Sms;
 class Task{

 	/**
 	 * 向阿里请求短信
 	 *@param data 
 	 *@param server
 	 */
 	public function sendSms($server,$data)
 	{
 		//这里如果不联网的话，阿里发布了curl是会报错的
 		try {
		 $respond=Sms::sendSms($data['phone'],$data['code']);
    	
		 } catch (Exception $e) {
		 	
		   return 	$e->getMessage();
		 }
        //if send success
		 if($respond->Code === "OK")
		{

         //这里改用同步的方式来操作redis
			Predis::getInstance()->set(Redis::smsKey($data['phone']),$data['code'],config("redis.out_time"));
            

			//make the nums into redis(xiecheng)
			// $redis=new \Swoole\Coroutine\Redis();
			// $redis->connect(config("redis.host"),config("redis.port"));
			// $redis->set(Redis::smsKey($phoneNum),$code,config("redis.out_time"));


		}else{
			return 	false;
		} 
	  return true;

 	}
     
     /**
      * @param fd 客户端fd
      * @param server 
      * @param data
      */


 	public function client_allpush($server,$data)
 	 {
 	 	 $fds=Predis::getInstance()->sMembers(config("redis.live_game_fd"));

       foreach ($fds as $key => $value) {

       	  $server->push($value,json_encode($data));

       }

 	 }


 }