<?php
namespace app\index\controller;
use app\common\lib\ali\Sms;
use app\common\lib\redis\Predis;
use app\common\lib\Util;
use app\common\lib\Redis;
use  think\Cookie;
class  Login
{
    /**
     * login
     */
    public function index()
    {
        //phone code
        $phoneNum = intval($_GET['phone_num']);
        $code = intval($_GET['code']);
        //redis code 
        if(empty($phoneNum)||empty($code))
        {
          return Util::show(config('code.error'),'login error');

        }
        

           $get_code=Predis::getInstance()->get(Redis::smsKey($phoneNum));
            
          if($get_code == $code)
          {
            //success  set the user active
            $data=[
              'user' => $phoneNum,
              'srcKey' =>md5(Redis::userKey($phoneNum)),
              'time' =>time(),
              'isLogin' => true,

            ];

       $res=Predis::getInstance()->set(Redis::userKey($phoneNum),json_encode($data),36000);

            //这里设置cookie来判断用户登录状态(100小时过期)
             // Cookie::set($phoneNum,'active',36000); 
             // var_dump($data);
            return Util::show(config("code.success"),'ok',$data);



          }else{
            return Util::show(config("code.error"),'login error');
          }
                
        

        

    


    }
    //判断是否登录
    public function IsLogin()
    {
      $user_mobile=$_GET['user'];
    
      //查询redis中是否有该用户的注册信息。登录状态是否为1
      $result=Predis::getInstance()->get(Redis::userKey($user_mobile));
      //转换成数组
      $result=json_decode($result,true);
     
      if($result['isLogin']== 'true')
      {
        return Util::show(config("code.success"),'has logined');
      }
      {
        return Util::show(config("code.error"),'not login');
      }



    }
     
   
    		
    
}
