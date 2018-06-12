<?php
$worker=new GearmanWorker();
$worker->addServer();
$worker->addFunction('test','someNew');



while (1)
{
    $worker->work();
    if($worker->returnCode() != GEARMAN_SUCCESS)
        break;
}


function someNew($job)
{

    $b=rand(0,10000000);
    $b.=PHP_EOL;
    sleep(15);
    echo $b;
    return $b;
}

