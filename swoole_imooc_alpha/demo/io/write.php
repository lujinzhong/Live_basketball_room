<?php

 $content="mclink is good".PHP_EOL;
 $res=swoole_async_writefile('write.log', $content, function($filename) {
    //todo
    echo "yes".PHP_EOL;
}, FILE_APPEND);
var_dump($res);
echo "   success";