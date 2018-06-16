<?php
//----------------------------------------------------------------------------------------------------------------------'
# Как оказалось, сериализация очень хорошо себя показывает при сохранении данных
#
#   Некоторые функции чисто физически не записывают массив, что может нам попортить все планы
#


function saveFile($file,$data)
{

	$dataOld=file_get_contents($file);
	return ( file_put_contents($file,$dataOld."\n".$data));
}

$links=getPaginationLinksList($neededUrl);
$topics=array_map('getForumPageTopics',$links);
$file1=realpath(__DIR__."/../files/withoutSerialize.txt");
$file2=realpath(__DIR__."/../files/Serialize.txt");
saveFile($file1,$topics);
saveFile($file2,serialize($topics));

