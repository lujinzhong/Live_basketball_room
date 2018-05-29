<?php
  class Ws{

  const Host ="127.0.0.1";
 	const Port = "8811";
  const ListenPort = '8812';
 	public $ws=null;

 	public function __construct()
 	{
 		$this->ws = new swoole_websocket_server(self::Host, self::Port);
    //增加一个监听端口用来聊天
    $port1 = $this->ws->listen(self::Host, self::ListenPort, SWOOLE_SOCK_TCP);

 		$this->ws->set([
 			'worker_num'=>4,
      'task_worker_num'=>4,
      'enable_static_handler' => true,
      'document_root' =>__DIR__."/../public/static",
    
		]);
   
   
         $this->ws->on("open",[$this,"onOpen"]);

         $this->ws->on("WorkerStart",[$this,"onWorkerStart"]);
         $this->ws->on("message",[$this,"onMessage"]);

         $this->ws->on("task",[$this,"onTask"]);

         $this->ws->on("request",[$this,"onRequest"]);

         $this->ws->on("finish",[$this,"onFinish"]);

		     $this->ws->on("close",[$this,"onClose"]);

		     $this->ws->start();

 	}

  /**
   *客户端开启
   * open
   */
  public function onOpen($ws, $request){

     //这里当有一个客户端进行连接时，将分配的fd存进redis有序列表中
  \app\common\lib\redis\Predis::getInstance()->sAdd(config("redis.live_game_fd"),$request->fd);
   // print_r($ws);
     print_r($request->fd);
       echo "server: handshake success with fd{$request->fd}\n";

  }

  /**
   *客户端发送信息
   * message
   */
  public function  onmessage($ws, $frame){


          $ws->push($frame->fd, "I hava received your data is:{$frame->data}");
         
        


  }

/**
 *worker  启动事件
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


   //当服务重启时，判断是否redis中该key是否有赋值，有的话就清空，以防重启后之前的fd还在。
    //先获取所有的成员，再一次性批量删除

    $set=\app\common\lib\redis\Predis::getInstance()
  ->sMembers(config("redis.live_game_fd"));
   if(!empty($set))
   {
    foreach ($set as $key => $value) {
    \app\common\lib\redis\Predis::getInstance()->sRem(config("redis.live_game_fd"),$value);
      
    }
   

   }
    

}

/**
 * ontask
 * 将短信请求放在task中
 */
 public function onTask($ws,$work_id,$task_id,$data)
 {

 	/**
 	 * 这里为了方便各种task任务的分发，应特地写出一个特别的task类，以至于可以反应不同的task对应的方法。
 	 */
      $task=new \app\common\lib\task\Task();
 	  
 	  $method=$data['method'];
    
 	  
 	  $task->$method($this->ws,$data['data']);

       
        return true;



 }

/**
 *当客户端发起request请求
 * request
 */
public function onRequest($request,$response)
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
    //这里因为上传图片需要也要设置一下转换
    $_FILES = [];
    if(isset($request->files)) {
        foreach($request->files as $k => $v) {
            $_FILES[$k] = $v;
        }
    }


    //post
    $_POST = [];
    if(isset($request->post)) {
        foreach($request->post as $k => $v) {
            $_POST[$k] = $v;
        }
    }

    //将ws对象传递给send.php
    $_POST['http_server']=$this->ws;
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
    //$ws->close();
    

}


 /**
  *事件完成时触发，使用task必写
  * task
  */
 	public function onFinish($task_id)
 	{




 	}
 	/**
   *客户端断开链接
 	 * close
 	 */
 	public function onClose($ws,$fd){

     //这里当有一个客户端断开连接时，将分配的fd删除
    \app\common\lib\redis\Predis::getInstance()->sRem(config("redis.live_game_fd"),$fd);
 		 // echo "client {$fd} closed\n";

	    }


  }
  new Ws();