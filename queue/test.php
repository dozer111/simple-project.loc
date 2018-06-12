<?php


echo gearman_version().PHP_EOL;

var_dump(require_once "require1.php");
var_dump(require_once "../queueTest/require3.php");
var_dump(require_once "../queueTest/require4.php");

require1::test();
require3::test();
require4::test();