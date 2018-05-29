<?php
 namespace app\index\controller;
 use app\common\lib\Util;
	class Chat{
		public function index()
		{
		//进行数据的判断
  if(empty($_POST['text'])||empty($_POST['game_id'])||empty($_POST['user']))
		{
			return Util::show(config("code.error"),'param error');
		}

	     $text=$_POST['text'];
		 $game_id=$_POST['game_id'];
		 $user =$_POST['user'];
		 $nickname=substr($user,-6);
		 $data=[
		 	'userid'=>"mc-".$nickname,
		 	'content'=>$text
		 ];

	foreach($_POST['http_server']->ports[1]->connections as $fd) 
	{
	  
       $_POST['http_server']->push($fd,json_encode($data));
    }
    // dump("aaaa");
      // return "success";
			// echo 111;
			// print_r($_POST[]);
			// $content=$_POST['data'];
			// var_dump($content);
            // dump($_POST);





		}








	}