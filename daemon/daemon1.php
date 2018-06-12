<?php

$child_pid=pcntl_fork();

if($child_pid)
{
    exit();
}
posix_setsid();

$baseDir=dirname(__FILE__);

# изменяет настройки конфигурации php.ini скрипта на время выполнения
ini_set('error_log',$baseDir.'/error.log');

# fclose -> закрывает файл по указанному дескриптору
// Дескриптор == неотрицательное целое число, которое создаётся при создании потока ввода/вывода
// в моём случае при создании демона

// 0.0 акрываем стандартные потоки вывода
fclose(STDIN);
fclose(STDOUT);
fclose(STDERR);

// 0.1 перенаправляем их в файл

$STDIN=fopen('/dev/null','r');
$STDOUT=fopen($baseDir.'/application.log');
$STDERR=fopen($baseDir.'/daemon.log','ab');

// 1 подключаем и запускаем сам демон
include "DaemonClass.php";
$daemon=new DaemonClass();
$daemon->run();