<?php

$client=new GearmanClient();
$client->addServer();

do{
    $client->doBackground('test','12345');
}
while($client->returnCode()!==GEARMAN_SUCCESS);
