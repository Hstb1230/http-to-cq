<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'CoolQ.config.php';
$array = $CQ->receive(); //接收插件推送的数据
if(!$array) exit; //没传入数据，终止运行

switch ($array['type']) {
    case 1:
        //私聊信息
        $CQ->sendPrivateMsg($array['qq'],'收到一条消息:'.$array['msg']);
        break;

    case 2:
        //群聊天信息
        //$CQ->sendGroupMsg($array['group'],"本次消息结构体：\r\n".print_r($array,true));
        //$CQ->sendGroupMsg($array['group'],"本次消息(仅文本)：\r\n".$array['msg']);
        if($array['msg']=='你好') $CQ->sendGroupMsg($array['group'],'我是小娜');
        break;

    case 4:
        //讨论组信息
        $CQ->sendDiscussMsg($array['group'],'FromHttpSocket:'.$array['msg']);
        break;

    default:

}
unset($CQ);//释放连接

