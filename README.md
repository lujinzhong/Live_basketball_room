# Live_basketball_room
跟着singwa老师做的一个高性能篮球赛况直播室，主要包含实时直播模块和多人聊天模块，采用TP5整合原生swoole拓展编写。入门swoole最佳实战

高性能直播赛事平台-这是慕课swoole实战的项目,有些必要功能已完善,开发环境基于

Linux (Ubuntu 16.04LTS) 

PHP-7.2.5 

swoole-2.1.2

Redis-4.0.9

nginx-1.13.12

mysql-5.7.18

thinkphp-5.1

layer

本项目主要有两个版本，其中alpha测试版只包含基础功能，即只到第九章的内容，而beta测试版则有了alpha版没有的功能，包含：

1.请求访问写入日志功能

2.nginx转发功能

3.nginx多台服务器负载均衡配置

4.平滑重启脚本

5.多请求过滤

6.服务报警监控

其中的thinkphp是主要项目文件，其余的demo都是测试swoole代码用的。注释写的不少。认真的看应该都能看懂。

如何使用：
1.环境要求（基本）：项目只能运行在linux系统，并确保安装了PHP环境以及安装了swoole拓展，并且swoole开启了异步redis，还有普通的redis也要安装，因为项目中中也有同步redis，tp5的对swoole的适配已经在源码中做好，最好直接按我的开发环境来。

2.如何调试：首先开启redis服务器端,再进入到thinkphp/script/bin/server/中,使用命令行执行：php ws_server.php,如果环境正确则不会报错。如果你使用的beta版的，因为添加了日志功能，所以每当有请求命令行会打印出日志信息，此时你应该执行一个脚本将日志输出到指定位置：
//这里可以使nohub来后台执行脚本，并且把输出的内容指定到一个文档中
 //nuhub /home/xiaolu/php/bin/php  /home/xiaolu/web/swoole_imooc/thinkphp/script/monitor/server.php >/home/xiaolu/web/swoole_imooc/thinkphp/script/monitor/log.text &
 websocket的默认端口为8811，监听的IP地址为127.0.0.1，在浏览器中使用地址：http://127.0.0.1:8811/live/login.html 进入了登录界面后 ，通过阿里的手机验证码可以正常的进行登录，这里是使用redis作为登录凭证的，redis存储的格式为sms_电话号码，因为我在源码中把阿里的短信验证凭证改了（文件在app\common\lib\ali\Sms类中），你需要正确配置你自己的凭证，或者直接在redis中执行 set sms_你的电话 123456,这样的话你就可以直接用123456作为你的验证码直接登录了.同样可以用这种方式这样多用户登录，多个用户登录后，可以直接测试聊天室功能，这个功能是属于不写入数据库的，因为实在没必要写这些重复性增删改查操作，你在聊天室输入内容后直接回车，其他用户便会实时收到你的信息，这时注意如果强刷页面就会消失了，实际上的聊天室是会记录到mysql数据库中的，但是这里我只是把收到的信息使用js让其显示到页面上而已。后台主持人功能使用浏览器访问：http://127.0.0.1/live/admin/live.html 界面比较粗糙，毕竟是测试版的。这里的话是默认指定了两支球队，实际上应该是从数据库进行动态显示的，写入内容选择发布即可，这时所有连接的客户端都会收到你发出的内容。核心代码都已经写好，数据库建表的文件也在那里，实际上需要完善的话只要建好数据库，把球队信息啥的录入进去，在完善一下页面，通信的模块基本不用改，需要改的都是普通的操作，懂tp5的很简单就能完成了。

这里我将安装环境所需的各类源码包也上传了。需要的话可以用。

我知道你们还是想看效果图的，那我还是放一下吧：
（客户端界面基于移动端，后台页面基于PC端）

登录界面：
![](https://github.com/lujinzhong/Live_basketball_room/blob/master/image/login.png)

登录后界面：
![](https://github.com/lujinzhong/Live_basketball_room/blob/master/image/登录完.png)

聊天室界面：
![](https://github.com/lujinzhong/Live_basketball_room/blob/master/image/聊天室.png)

主持人界面：
![](https://github.com/lujinzhong/Live_basketball_room/blob/master/image/主持人.png)


建议环境自己搭建，不要说学swoole的PHPer连基本环境都不会搭，遇到坑就多查资料，没有过不去的坑。实在不行，没办法了，那就用我的导出虚拟机系统包把，用vmware导入即可，源码和环境都有了。最后祝大家swoole学习愉快。过段时间会放出一个用easyswoole写的web QQ群聊聊天室源码。
