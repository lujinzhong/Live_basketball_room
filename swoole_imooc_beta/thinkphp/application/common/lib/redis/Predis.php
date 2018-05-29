<?php
namespace app\common\lib\redis;

 class Predis {
    public $redis="";

 	/**
 	 * danlihua
 	 */
    private static $_instance = null;
    
    public static function getInstance(){
    	if(empty(self::$_instance))
    	{
    		self::$_instance = new self();
    		
    	}
    		return self::$_instance;
    	
    }

    private function __construct()
    {
    	try {
    		$this->redis=new \Redis();
    	$result=$this->redis->connect(config("redis.host"),config("redis.port"),config("redis.timeOut"));

    	} catch (Exception $e) {
    		$e->getMessage();
    	}
    	

    	//connect error?
    	if($result === 'false')
    	{
    		throw new Exception("redis connect error");
    		
    	}
    }


    //封装一些redis函数，使得可以直接使用PHP来操作redis数据库

    public function set($key,$value,$time = 0)
    {
    	if(!$key)
    	{
    		return "";
    	}
    	if(is_array($value))
    	{
    		$value=json_encode($value);
    	}
    	if(!$time)
    	{
    		$this->redis->set($key,$value);
    	}else{
    		$this->redis->setex($key,$time,$value);

    	}

    	

    }

    public function get($key)
    {
    	if(!$key)
    	{
    		return '';
    	}
      return  $this->redis->get($key);
    }
    
    


    /**
     * 增加有序列表的函数
     */
    public function sAdd($key,$value)
    {
        return  $this->redis->sAdd($key,$value);

    }

    /**
     * 删除有序列表的某个值
     */
    public function sRem($key,$value)
    {
        return  $this->redis->sRem($key,$value);

    }


    /**
     * 获取有序列表的所有值
     */
    public function sMembers($key)
    {
        return $this->redis->sMembers($key);
    }




 }