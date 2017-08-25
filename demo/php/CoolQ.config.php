<?php

/**
 * 接口配置文件
 */

define('SITE_PATH',dirname(__FILE__).'/');

$url = 'http://127.0.0.1'; //服务器地址
$port = 9999; //监听端口
if($port!=80) $url .= ':'.$port;

$useCheck = false; //不校验数据
$key = '123'; //校验数据所需要的密钥
$effectTime = 30; //数据有效期

$format = 'JSON'; //数据格式，如果使用 Key=Value 格式，请设置为 KV

include SITE_PATH.'CoolQ.class.php';

$CQ = new CoolQ($url,$useCheck,$key,$effectTime,$format);