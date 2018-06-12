<?php
/**
 * Демон, который форкает себя от родителя и работает в фоне.
 * Пока что никаких обработок сигналов
 *
 */


$pid=pcntl_fork();
$status=true;

if($pid==-1)
{
    exit('Error. Process'.$pid.' wasn`t forked!');
}
elseif($pid)
{
    exit('Kill parent process');
}
else {
    posix_setsid();

    $fileName='/var/www/simple-project.loc/files/test1.txt';
    $counter=0;
    while($status)
    {

        $a=file_get_contents($fileName);
        $b=' ,'.$counter."\n";
        file_put_contents($fileName,$a.$b);
        sleep(15);
        $counter++;
        if($counter>11)$status=false;
    }


}
