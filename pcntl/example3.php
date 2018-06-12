<?php
/**
 * Проверяем работу перезагрузки процесса
 */

declare(ticks = 1);


# объявляем настройки
$date = date('Y-m-d H:i:s');


# обработаем сигналы перезапуска процесса
pcntl_signal(SIGHUP, "sig_handler");



# обработчик сигнала с процедурой завершения
function sig_handler($signo)
{
    global $date;

    # обновляем настройки (дату)
    echo "\n" . 'Reloading config...' . "\n";
    $date = date('Y-m-d H:i:s');
}



# бесконечный цикл
while ( true )
{
    echo $date . ': ';

    for ( $i = 0; $i < 3; $i++ )
    {
        echo '.';
        sleep(1);
    }

    echo "\n";
}


# команды для проверки:
# 1 ==>      php -f pcntl/example3.php
# 2 ==>      pkill -HUP -f pcntl/example3.php
