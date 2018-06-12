<?php
/**
 * Обработка процессов окончания/прерывания процесса
 */


declare(ticks=1);
pcntl_signal(SIGINT,'myFunc');
pcntl_signal(SIGTERM,'myFunc');

function myFunc($signo)
{
    # закончим выполнение задач
    echo "\n" . 'received quit signal, finishing tasks ' . "\n";
    for ( $i = 0; $i < 10; $i++ ) echo '-';
    echo "\n" . 'Done' . "\n";

    # остановим выполнение скрипта
    exit;
}


# бесконечный цикл
while ( true )
{
    for ( $i = 0; $i < 3; $i++ )
    {
        echo '.';
        sleep(1);
    }

    echo "\n";
}


# функции для проверки:
# 1 ==>      php -f pcntl/example2.php
# 2 ==>      pkill -f pcntl/example2.php
# 3 ==>      ctrl+C на обрабатывающем фрейме
