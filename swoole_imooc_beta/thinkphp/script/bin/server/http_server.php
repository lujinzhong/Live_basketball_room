<?php
 use app\common\lib\task\Task as Task;
 /**
 * httpclass
 */
 class 	HttpClass
 {
 	const Host ="127.0.0.1";
 	const Port = "9501";
 	public $http=null;

 	public function __construct()
 	{
 		$this->http = new swoole_http_server(self::Host, self::Port);
 		$this->http->set([
 			'worker_num'=>4,
           'task_worker_num'=>4,
           'enable_static_handler' => true,
           'document_root' =>__DIR__."/../public/static",
    
		]);
 		 
   


         $this->http->on("WorkerStart",[$this,"onWorkerStart"]);
         $this->http->on("task",[$this,"onTask"]);

         $this->http->on("request",[$this,"onrequest"]);

         $this->http->on("finish",[$this,"onFinish"]);

		 $this->http->on("close",[$this,"onclose"]);

		 $this->http->start();

 	}

/**
 * workerstart
 */
 public function onWorkerStart($server, $worker_id)
{
	// 定义应用目录
      define('APP_PATH', __DIR__ . '/../application/');
      // ThinkPHP 引导文件
      // 加载基础文件
      //如果这里不使用start的话，下面的app\common\lib\al\Sms这个类就会找不到，此时应该把index/index/index方法的输出改为空，不然那些输出都会到控制台里输出。
      //require __DIR__ . '/../thinkphp/base.php';
       require __DIR__ . '/../thinkphp/start.php';
}

/**
 * ontak
 * 将短信请求放在task中
 */
 public function onTask($http, $taskid,$workerid, $data)
 {

 	/**
 	 * 这里为了方便各种task任务的分发，应特地写出一个特别的task类，以至于可以反应不同的task对应的方法。
 	 */
      $task=new Task();
 	  
 	  $method=$data['method'];
 	  
 	  $task->$method($data['data']);

       
        return true;



 }

/**
 * request
 */
public function onrequest($request,$response)
{

 	 $_SERVER  =  [];
    //server
    if(isset($request->server)) {
        foreach($request->server as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    //header
    if(isset($request->header)) {
        foreach($request->header as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    //get
    $_GET = [];
    if(isset($request->get)) {
        foreach($request->get as $k => $v) {
            $_GET[$k] = $v;
        }
    }
    //post
    $_POST = [];
    if(isset($request->post)) {
        foreach($request->post as $k => $v) {
            $_POST[$k] = $v;
        }
    }

    //将http对象传递给send.php
    $_POST['http_server']=$this->http;
    //开启缓冲区
    ob_start();
    // 执行应用并响应
    try {
        think\Container::get('app', [APP_PATH])
            ->run()
            ->send();
    }catch (\Exception $e) {
        // todo
    }
    //输出TP当前请求的控制方法
    //echo "-action-".request()->action().PHP_EOL;
    //获取缓冲区内容

    

    $res = ob_get_contents();
    ob_end_clean();

    // $response->header("Content-Type","text/html");
    $response->header("charset","utf-8");
    $response->end($res);
    //把之前的进程kill，swoole会重新启一个进程，重启会释放内存，把上一次的资源包括变量等全部清空
    //$http->close();
    

}



 	public function onFinish($task_id)
 	{




 	}
 	/**
 	 * close
 	 */
 	public function onclose($http,$fd){
 		 echo "client {$fd} closed\n";
	    }


 	}
   $obj=new HttpClass();