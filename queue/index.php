<?php
/**
 * =====================================================================================================================
 * Простой пример создания очереди
 * =====================================================================================================================
 */



class firstQueue extends SplQueue
{

    public function dequeue()
    {
        echo "TEST";
        return parent::dequeue();
    }


}

$obj=new firstQueue();
$obj->enqueue('first');
$obj->enqueue('second');
$obj->enqueue('third');
$obj->enqueue('fourth');

var_dump($obj->dequeue());