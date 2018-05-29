<?php
 namespace app\admin\controller;
 use app\common\lib\redis\Predis;
 use app\common\lib\Util;
 use app\common\lib\task\Task;
 use think\Db;
 class Live{

 	public function push()
 	{
 		if($_POST['type']=='')
 		{
 			return Util::show(config("code.error"),'push error');
 		}
 		//赛况入库
        
        //这里先进行模拟数据
 		$team=[
 			'1' =>'马刺',
 			'4' =>'火箭',

 		];


        //把赛况推送给所有观看的用户
        //这里根据存在redis有序列表上的客户端fd号码来进行实时推送
       

        //先获取数据进行整理。
        if(!isset($_POST['image']));
        {
        	$_POST['image']='';
        }
        if(empty($_POST['team_id']))
        {
        	$team_name='解说员';
        }
        else{

        	$team_name=$team[$_POST['team_id']];
        }
        
 		$data=[
 			'type'     =>  $_POST['type'],    
 			'team_id'  =>  $team_name,
 			'image'    =>  $_POST['image'],
 			'content'  =>  $_POST['content'],

 		];
        
       //将数据推给所有连接的客户端
 		//这里将推送任务放在task池中执行，增加用户体验

          //分发task任务数据

		 $taskdata=[
		     'method'=>'client_allpush',
		     'data'=>$data,
		 
		 	
		 ];
		 //use task
		 $_POST['http_server']->task($taskdata);
		 //使用完task后，可以直接访问正确的接口数据给前端，其他的交个task执行，增加用户体验
		 
		 return  Util::show(config('code.success'),'push  success');

 	}




 }