<?php 
  use app\common\lib\ali\Sms;
 //引入发短信
 class 	Server{

   const port = 8811;
   public function port(){
  
    //这里加了2>/dev/null是为了过滤掉原本前面的文字，而后面的grep LISTEN |wc -l则吧有监听的结果变为1，没有则为0，通过此可以判断
    $shell='netstat -anp 2>/dev/null | grep '.self::port." | grep LISTEN | wc -l";
    $result = shell_exec($shell);
    //echo $result.PHP_EOL;
    if($result == 1)
    {
    	//服务正常启动着
    	//echo "success".PHP_EOL;
    }else{
    	//这里报警短信发送，如果服务因某种原因停了的话
    	// Sms::sendSms('Your tel',44444);
    	echo date("Y-m-d H:i:s",time())."server error".PHP_EOL;
    }
   }

 }
 //nohub
 //这里可以使nohub来后台执行脚本，并且把输出的内容指定到一个文档中
 //nuhub /home/xiaolu/php/bin/php  /home/xiaolu/web/swoole_imooc/thinkphp/script/monitor/server.php >/home/xiaolu/web/swoole_imooc/thinkphp/script/monitor/log.text &

// 1.nohup

// 用途：不挂断地运行命令。

// 语法：nohup Command [ Arg … ] [　& ]

// 　　无论是否将 nohup 命令的输出重定向到终端，输出都将附加到当前目录的 nohup.out 文件中。

// 　　如果当前目录的 nohup.out 文件不可写，输出重定向到 $HOME/nohup.out 文件中。

// 　　如果没有文件能创建或打开以用于追加，那么 Command 参数指定的命令不可调用。

// 退出状态：该命令返回下列出口值： 　　
// 　　126 可以查找但不能调用 Command 参数指定的命令。 　　
// 　　127 nohup 命令发生错误或不能查找由 Command 参数指定的命令。 　　
// 　　否则，nohup 命令的退出状态是 Command 参数指定命令的退出状态。
// 2.&

// 用途：在后台运行

// 一般两个一起用

// nohup command &



//ps aux | grep monitor/server.php   查询是否有执行该脚本的进程
//kill -9 进程号 杀死进程

 //这里使用swoole的毫秒定时器比如两秒执行一次
 swoole_timer_tick(2000, function(){

  (new Server())->port();

 });
