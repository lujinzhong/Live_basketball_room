<?php
namespace app\index\controller;
use app\common\lib\ali\Sms;
class Index
{
    public function index()
    {
        echo "";
       // echo "hello-mclink".PHP_EOL;
    	//echo APP_PATH.'../extend/ali/vendor/autoload.php';

    }
     
    public function login()
    {
      return phpinfo();
    } 
    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
    public function sms()
    {
    	
    	try {
    		$respond=Sms::sendSms(15626425282,123456);
    		echo "result:".$respond.PHP_EOL;
    		
    	} catch (Exception $e) {
    		//todo
    		
    	}
    	

    }
}
