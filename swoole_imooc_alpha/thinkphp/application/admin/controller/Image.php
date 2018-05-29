<?php
 namespace app\admin\controller;
 use app\common\lib\Util;
 class Image{

 	public function index(){

       //这里接收后台直播人员上传的图片，并保存。
 	   $file = request()->file('file');
 	   //这里默认的是目录是websocket脚本启动的位置，所以我们要更换一下路径，放到static里面。
 	   $info = $file->move('../public/static/upload');
 	   //print_r($info);
       //上传成功向前端发送成功的标志
       $data=[
       	'image' => config("live.host").'/upload/'.$info->getSaveName(),


       ];
       if($info)
       {
       	   return Util::show(config('code.success'),'upload success',$data);
       }
       else{
       	return Uitl::show(config("code.error"),'upload error');
       }

 	}




 }