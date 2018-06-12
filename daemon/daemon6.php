<?php
/**
 * ==============================================================================================================
 * Демон, который позволяет запускать себя  ТОЛЬКО в к-ве 1шт
 * ==============================================================================================================
 */


$status=true;

$logFileName='/var/www/simple-project.loc/logs/daemon.pid';
# если лог уже записан, значит смотрим, какой pid там есть
if(is_file($logFileName))
{
    $pid=file_get_contents($logFileName);
    if(posix_kill($pid,0))
    {
        exit("Демон уже запущен, ждите!!!");
    }



}





cli_set_process_title('My own daemon');

$pid=pcntl_fork();
$pid1=011;
file_put_contents($logFileName,$pid);





if($pid==-1)
{
    exit('Error. Process'.$pid.' wasn`t forked!');
}
elseif($pid)
{
    $pid1=$pid;
    exit('Kill parent process');
}
else {


    posix_setsid();
    $posix_id=posix_getsid(0);
    $posix_getpid=posix_getpid();
    $fileName='/var/www/simple-project.loc/files/test5.txt';
    $counter=0;
    while($status)
    {


        $a=file_get_contents($fileName);

        $b='PID = '.$pid1. ', posix_getsid ==> '.$posix_id.' posix_getpid ==> '.$posix_getpid.' counter ==> '.$counter."\n";
        file_put_contents($fileName,$a.$b);
        sleep(5);
        $counter++;
        if($counter>11){
            file_put_contents($fileName,$a.'================================================================'."\n");

            # удаляем лог файл с PID после окончания процесса
            unlink($logFileName);
            $status=false;
        }


    }


}
