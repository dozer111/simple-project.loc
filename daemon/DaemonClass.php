<?php

// перехватываем системные сигналы
declare(ticks=1);

class DaemonClass
{

    public $maxProcesses=5;
    # cтатус завершение работы демона
    protected $stop_server=false;
    # инф-я о запущенных дочерних процессах
    protected $currentJobs=[];


    public function __construct()
    {
        echo "Constructed php daemon1 daemon".PHP_EOL;

        pcntl_signal(SIGTERM,[$this,'childSignalHandler']);
        pcntl_signal(SIGCHLD,[$this,'childSignalHandler']);
    }


    /**
     * Метод для запуска демона
     *
     * Тут у нас и крутится бесконечтный цикл
     */
    public function run()
    {
        echo "Running php daemon1 daemon".PHP_EOL;

        while(!$this->stop_server)
        {
            while (count($this->currentJobs)>=$this->maxProcesses)
            {
                echo "Maximum children allowed".PHP_EOL;
                sleep(1);
            }

            $this->launchJob();
        }



    }


    
    public function launchJob()
    {
        $pid=pcntl_fork();

        if($pid==-1){
            echo "Не удалось создать новый дочерний процесс".PHP_EOL;
            return false;
        }

        elseif ($pid) $this->currentJobs[$pid]=true;
        else
            {
                echo 'Процесс с ID'.getmypid().PHP_EOL;
                exit();
            }

        return true;


    }



    /**
     * Теперь обработчик для сигналов
     */



















}