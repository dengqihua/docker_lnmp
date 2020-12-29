<?php
/**
* 测试redis，需要引入predis第三方包
* 当前目录下执行命令：composer require predis/predis
**/

require_once 'vendor/autoload.php';

$client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'redis',
    'port'   => 6379,
]);
$client->set('name', 'dengqihua');
$value = $client->get('name');
var_dump($value);