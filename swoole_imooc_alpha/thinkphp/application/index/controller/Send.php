<?php
namespace app\index\controller;
use app\common\lib\ali\Sms;
use app\common\lib\Util;
use app\common\lib\Redis;
use think\Validate;

class Send
{
	//send the captcha
    public function index()
    {

    	
    	//receive the phonenumber
    	$phoneNum=intval($_GET['phone_num']);
    	//$phoneNum=input("phone_num");
        //judge the phonenumber
       
    	if(empty($phoneNum))
    	{
    		return Util::show(config('code.error'),'error');
    	}
        //not null validate the phonenumber
        $validate = new Validate([
			'phoneNum' => '/^[1][3,4,5,7,8][0-9]{9}$/',
			
			]);
			$data = [
			'phoneNum' => $phoneNum,
			];
			if (!$validate->check($data)) {
			  return Util::show(config('code.error'),'invalid phone');
			}

		 //all right
		 $code=rand(1000,9999);
		 
		
		 //分发task任务数据

		 $taskdata=[
		     'method'=>'sendSms',
		     'data'=>[
		      'phone'=>$phoneNum,
		 	 'code'=>$code,
		     ],
		 	
		 ];
		 //use task
		 $_POST['http_server']->task($taskdata);
		 //使用完task后，可以直接访问正确的接口数据给前端，其他的交个task执行，增加用户体验
		 
		 return  Util::show(config('code.success'),'success');

		
		//all down
		//return  Util::show(config('code.success'),'success');     

    }
     
   
}
