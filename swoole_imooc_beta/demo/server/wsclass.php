<?php
 
 /**
 * Wsclass
 */
 class 	Wsclass 
 {
 	const Host ="127.0.0.1";
 	const Port = "8866";
 	public $ws=null;

 	public function __construct()
 	{
 		$this->ws = new swoole_websocket_server("127.0.0.1", 8866);
 		$this->ws->set([
		    'enable_static_handler' => true,
		    'document_root' =>"/home/xiaolu/web/swoole_imooc/html",
		]);
 		 // open
 		 $this->ws->on("open",[$this,"onopen"]);

 		 $this->ws->on("message",[$this,"onmessage"]);
 		 
 		 $this->ws->on("close",[$this,"onclose"]);

 		 $this->ws->start();

 	}

 	/**
 	 * open
 	 */
 	public function onopen($ws, $request){

 		 print_r($request->fd);
	     echo "server: handshake success with fd{$request->fd}\n";
	     if($request->fd==3){
	     	swoole_timer_tick(2000, function($timer_id){

	     	echo "timer_id:{$timer_id}\n";


	     });

	     }

	     


 	}

 	/**
 	 * message
 	 */
 	public function  onmessage($ws, $frame){

 		echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";


	        $ws->push($frame->fd, "I hava received your data is:{$frame->data}");
	        swoole_timer_after(5000,function()use($ws,$frame){

	        	echo "this is after 5s :--{$frame->fd}--{$frame->data}";
	        	$ws->push($frame->fd,"this is from server:{$frame->data}");
	        });


 	}

 	/**
 	 * close
 	 */
 	public function onclose($ws,$fd){
 		 echo "client {$fd} closed\n";
	    }


 	}
   $obj=new Wsclass();