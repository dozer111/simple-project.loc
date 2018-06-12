<?php
/**
 * Простой демон 2, теперь он умеет обрабатывать сигналы POSIX
 */



# declare ==> установка директив для исполнения блока кода, расположенного ниже declare
declare(ticks=1);
$status=true;

function sigHandler($signal)
{
    global $status;
    switch ($signal)
    {
        case SIGTERM:
//Пример 1: я просто обрабатывал сигнал
//            echo "Делаем что-то по приходу сигнала об окончании процесса";
//            sleep(15);
//            # спокойно ложим демона
//            $status=false;
//            break;


            # а теперь, я попробую положить процесс внутри процесса (сам корректно обработать его завершение
            # + оповестить об этом пользователя ) == неудалось
            $status=false;
            echo "Процесс завершился корректно, данный демон отключен";
            break;

        case SIGUSR1:
            echo "Была вызвана функция 1";
            break;
        case SIGUSR2:
            echo "Была вызвана функция 2";
            break;
        default:
            echo "Была вызвана ф-я, которая нас, мягко говоря не ебёт";
            break;
    }

}



//---------------------------------------------------------------------------------------------------------------
// Блок обработки входящих сигналов

pcntl_signal(SIGTERM,'sigHandler');
pcntl_signal(SIGUSR1,'sigHandler');
pcntl_signal(SIGUSR2,'sigHandler');

cli_set_process_title('My own daemon');

$pid=pcntl_fork();
$pid1=011;
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
    $fileName='/var/www/simple-project.loc/files/test3.txt';
    $counter=0;
    while($status)
    {

        $a=file_get_contents($fileName);
        # тут для наглядности представленные данные с таких ф-й
        # pcntl_fork        ==> PID
        # posix_getsid      ==> posix_getsid

        $b='PID = '.$pid1. ', posix_getsid ==> '.$posix_id.' posix_getpid ==> '.$posix_getpid.' counter ==> '.$counter."\n";
        file_put_contents($fileName,$a.$b);
        sleep(5);
        $counter++;
        if($counter>11)$status=false;
        # пример с собственным завершением внутри процеса

    }


//--------------------------------------------------------------------------------------------------
/**
 * Итого, данный демон уже может обрабатывать команды, но, пока что не может завершится, известив
 * корректно об этом пользователя
 */

}
