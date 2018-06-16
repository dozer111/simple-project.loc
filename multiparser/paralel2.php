<?php
# Пример 1: запускаю несколько процессов из-под одного

echo "START WORKING".PHP_EOL;


$childProcess=[];

for($i=1;$i<5;$i++)
{
	$newPid=pcntl_fork();

	if($newPid==-1)
	{
		echo "Process on ".$i." iteration was failed".PHP_EOL;
	}
	elseif ($newPid)
	{
		$childProcess[]=$newPid;
		echo "Main process create subprocess ==> ".$newPid.PHP_EOL;

		if($i==4)
		{

			echo "Main process waiting for done other processes".PHP_EOL;
			foreach ($childProcess as $child)
			{
				pcntl_waitpid($child,$status);
				echo "OK subprocess ".$child." is ready".PHP_EOL;
			}
		}

	}
	else
		{
			$myPid=getmypid();
			echo "I`m forked process from ".$myPid.PHP_EOL;
			#sleep(rand(5,20));
			echo "Subprocess ".$myPid." already done".PHP_EOL;
			die(0);
		}


echo "Parent script done!";
print_r($childProcess);
}
