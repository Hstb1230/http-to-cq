<?php

if(!defined('SITE_PATH')) exit;

/**
 * 接口配置文件
 */

/**
 * 动态交互 设置
 * 如果 $CoolQ_Config_url 不为空，视为使用动态交互功能
 */
$CoolQ_Config_url = '127.0.0.1'; //酷Q所在服务器的IP地址(可为域名)
$CoolQ_Config_port = 9999; //动态交互的监听端口

/**
 * 校验数据设置
 * 如果 $key 不为空，则视为使用校验数据功能
 */
$CoolQ_Config_key = ''; //校验数据所需要的密钥，该值需与插件设置保持一致
$CoolQ_Config_effectTime = 30; //数据有效期

$CoolQ_Config_Receive_format = 'JSON'; //接收的数据格式，如果使用 Key=Value 格式，请设置为 KV

$CoolQ_Config_Receive_from = 'push'; //事件数据的获取方式，push/插件推送、obtain/从插件获取(需启用动态交互功能)
$CoolQ_Config_Receive_limit = 5; //单次获取的事件数量，仅在 obtain 下有效

$CoolQ_Config_openDebug = true; //开启调试模式

/** 处理下参数 **/
if($CoolQ_Config_port!=80 && $CoolQ_Config_url) $CoolQ_Config_url .= ':'.$CoolQ_Config_port;
if($CoolQ_Config_url) $CoolQ_Config_url = "http://$CoolQ_Config_url/";
if($CoolQ_Config_openDebug) define('CoolQ_Debug', true);
unset($CoolQ_Config_openDebug);
if($CoolQ_Config_Receive_from == 'obtain') {
    $CoolQ_Config_Receive_format = 'JSON'; //强制使用JSON
    if(!$CoolQ_Config_url) $CoolQ_Config_Receive_from = 'push'; //从插件获取数据需启用动态交互
}

$CQ = new CoolQ($CoolQ_Config_url, $CoolQ_Config_key, $CoolQ_Config_effectTime, $CoolQ_Config_Receive_format);
unset($CoolQ_Config_url, $CoolQ_Config_key, $CoolQ_Config_effectTime, $CoolQ_Config_Receive_format);
