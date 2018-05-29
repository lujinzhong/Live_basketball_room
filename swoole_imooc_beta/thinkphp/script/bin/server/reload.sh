echo "loading...";
pid = `pid of live_master`;
echo $pid;
kill -USR1 $pid;
echo "success restart";
#sigterm 重启服务器用的
#sigusr1 重启worker进程用的
#sigusr2 重启task_worker进程用的

#启用平滑重启(后台不间断运行)
#nohup sh /home/xiaolu/web/swoole_imooc/script/bin/server/reload.sh > /home/xiaolu/web/swoole_imooc/script/bin/server/reload.log &