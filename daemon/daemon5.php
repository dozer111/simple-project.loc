<?php
/**
 * Демон, который просто грузит ЦПУ
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

        usleep(50000);

    }


}
