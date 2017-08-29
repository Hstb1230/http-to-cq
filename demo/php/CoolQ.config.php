<?php

/**
 * 接口配置文件
 */

/**
 * 动态交互 设置
 * 如果 $url 不为空，视为使用动态交互功能
 */
$url = 'http://127.0.0.1'; //服务器地址
$port = 9999; //监听端口
if($port!=80 && $url) $url .= ':'.$port;

/**
 * 校验数据设置
 * 如果 $key 不为空，则视为使用校验数据功能
 */
$key = ''; //校验数据所需要的密钥
$effectTime = 30; //数据有效期

$format = 'JSON'; //数据格式，如果使用 Key=Value 格式，请设置为 KV

define('SITE_PATH',dirname(__FILE__).'/');
include SITE_PATH.'CoolQ.class.php';
$CQ = new CoolQ($url,$key,$effectTime,$format);