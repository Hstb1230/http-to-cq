<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

include 'CoolQ.config.php';
$array = $CQ->receive(); //接收插件推送的数据
if(!$array) exit; //没传入数据，终止运行

switch($array['type']) {
    case 1:
        //收到私聊信息
        $qq = $array['qq'];
        $msg = $array['msg'];
        $CQ->sendPrivateMsg($qq, "收到一条消息:$msg");
        break;

    case 2:
        //收到群聊天信息
        $group = $array['group'];
        $msg = $array['msg'];
        if($msg == '你好') {
            $CQ->sendGroupMsg($group, '我是小娜');
            //$CQ->sendGroupMsg($group,'本群：'.$group);
        }
        //$CQ->sendGroupMsg($group,"本次消息结构体：\r\n".print_r($array,true));
        //$CQ->sendGroupMsg($group,"本次消息(仅文本)：\r\n$msg");
        break;

    case 4:
        //收到讨论组信息
        $group = $array['group'];
        $msg = $array['msg'];
        //$CQ->sendDiscussMsg($group, "FromHttpSocket:$msg");
        break;

}
unset($CQ);//释放连接
