<?php

use Symfony\Component\DomCrawler\Crawler;

require_once realpath(__DIR__.'/../vendor/autoload.php');

$neededUrl='viewforum.php?f=28';



/**
 * @param string $url
 * @param string|null $baseUrl
 * @return string
 *
 * Ф-я которая делает полные URL с неполных, которые будут в результате парсинга:
 * входной $url            ==>  /news?page=5&per-page=25
 * на выходе               ==>  www.siteName.com/news?page=5&per-page=25
 */
function normalizeUrl(string $url,string $baseUrl=null)
{
     $baseUrl=($baseUrl==null)?'https://yiiframework.ru/forum/':$baseUrl;
     return $baseUrl.$url;
}

function getHtml(string $url)
{
    return file_get_contents(normalizeUrl($url));
}



function getMaxPages($url)
{
    $html=getHtml($url);
    $crawler=new Crawler($html);
    $max= $crawler
        ->filter('div.pagination ul >li')
        ->each(function (Crawler $link)
        {
            return intval($link->text());
        });
    $max=max(max($max),1);
    return $max;
}



function getPaginationLinksList($url)
{
    $maxPage=getMaxPages($url);

    $finalArray=[];
    foreach (range(1,$maxPage) as $page)
    {
        $finalArray[]=$url.($page>1 ? '&start='.(25*($page-1)):'' );
    }
    return $finalArray;

}


function getForumPageTopics($forumPageUrl)
{
    $html=getHtml($forumPageUrl);
    $crawler=new Crawler($html);

    $data=$crawler
        ->filter('ul.topiclist.topics li dl')
        #->filter('div.forumbg > div.inner >ul.topics > li.row # .row-item > dt >.list-inner a ')
        ->each(function (Crawler $test)
        {
            $test1=$test->filter('div.list-inner a.topictitle');
           return ['url'=>$test1->attr('href'),
               'title'=>$test1->text()];
        });

    #->each(function (Crawler $topic){
//            $topic->filter('dt:first-child .list-inner a.topictitle');
//            return ['url'=>$topic->attr('href'),
//                    'title'=>$topic->text()
//                ];
//        });
    return $data;
}

function saveFile($file,$data)
{

	$dataOld=file_get_contents($file);
	return ( file_put_contents($file,$dataOld."\n".$data));
}

//$links=getPaginationLinksList($neededUrl);
//$topics=array_map('getForumPageTopics',$links);
//$file1=realpath(__DIR__."/../files/withoutSerialize.txt");
//$file2=realpath(__DIR__."/../files/Serialize.txt");
//saveFile($file1,$topics);
//saveFile($file2,serialize($topics));





#print_r($links);
echo PHP_EOL;
#print_r($topics);
echo PHP_EOL;