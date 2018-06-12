<?php
/**
 * ===============================================================================================================
 * Демон с передачей параметров внутрь
 * ===============================================================================================================
 */


$status=true;


cli_set_process_title('My own daemon');


# смотрим, что же нам пришло с CLI процесса
$globalArguments=$argv;

$pid=pcntl_fork();

if($pid==-1)
{
    exit('Error. Process'.$pid.' wasn`t forked!');
}
elseif($pid)
{
    exit('Kill parent process'.PHP_EOL);
}
else {


    posix_setsid();

    $fileName='/var/www/simple-project.loc/files/test4.txt';
    $counter=0;
    while($status)
    {


            foreach ($globalArguments as $argument)
            {
                sleep(5);
                $a=file_get_contents($fileName);
                file_put_contents($fileName,$a.$argument."\n");
                sleep(5);

            }
            # php daemon/daemon4.php   1 2 3 4 coralina
            # php daemon/daemon4.php   vasia ivanow 11-b love natasha
        $status=false;
        # пример с собственным завершением внутри процеса

    }
    exit('Daemon work success!'.PHP_EOL);




}
