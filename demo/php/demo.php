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
            $CQ->sendGroupMsg($group, "你好\r\n我是小娜");
            $CQ->sendGroupMsg($group,'你是我的闺蜜Siri吗');
            $CQ->sendGroupMsg($group,$CQ->cqAt($array['qq']));
        }
        //$CQ->sendGroupMsg($group,"本次消息结构体：\r\n".print_r($array,true));
        //$CQ->sendGroupMsg($group,"本次消息(仅文本)：\r\n$msg");
        if($msg == '更新群成员信息'){
            $array = $CQ->getGroupMemberList($array['group']);
        }
        break;

    case 4:
        //收到讨论组信息
        $group = $array['group'];
        $msg = $array['msg'];
        $CQ->sendDiscussMsg($group, "FromHttpSocket:$msg");
        break;

    case 11:
        //有群成员上传文件
        $group = $array['group'];
        $file = $array['fileInfo'];
        $msg = $CQ->cqAt($array['qq']).'上传了文件';
        $msg .= "\r\n";
        $msg .= '文件名：'.$file['name'];
        $CQ->sendGroupMsg($group, $msg);
        break;

    case 103:
        //群成员增加
        $group = $array['group'];
        $qq = $array['beingOperateQQ'];
        $groupInfo = $CQ->getGroupInfo($group);
        $groupName = (!$groupInfo['status']) ? $groupInfo['result']['gName'] : '本群';
        $msg = '欢迎'.$CQ->cqAt($qq).'加入'.$groupName;
        $CQ->sendGroupMsg($group, $msg);
        break;
}
unset($CQ);//释放连接
