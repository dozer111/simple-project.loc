<?php
/**
 * Пример 1
 * Обрабатываю сигнал SIGTERM (сигнал окончания процесса)
 *
 *
 */



# назначаем обработчик сигнала
declare(ticks = 1);
pcntl_signal(SIGTERM, "sig_handler");


# обработчик сигнала
function sig_handler($signo)
{
    echo "\n" . 'received signal ' . $signo . "\n";
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

# в одном окне скрипт запускаю, во втором пытаюсь его прервать через
# php -f pcntl/example1
# pkill -f fileName.php