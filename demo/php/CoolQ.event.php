<?php

if(!defined('SITE_PATH')) exit;

if($CoolQ_Config_Receive_from == 'push') {
    //插件推送
    $eventHeap = [];
    $eventHeap[] = $CQ->receive();
} elseif ($CoolQ_Config_Receive_from == 'obtain') {
    //从插件主动获取
    $data = $CQ->receive($CoolQ_Config_Receive_from, $CoolQ_Config_Receive_limit);
    if(!$data['status']) $eventHeap = $data['event'];
    else $eventHeap = [];
    unset($data);
} else $eventHeap = [];

function treatEvent(CoolQ $CQ, array $eventHeap)
{
    foreach($eventHeap as $event) {
        //if(defined('CoolQ_Debug')) print_r($event);
        $type = $event['type'];
        $subType = $event['subType'];
        $time = $event['time'];
        switch($type) {
            //回调给处理函数
            case 1:
                //收到私聊信息
                $qq = $event['qq'];
                $msg = $event['msg'];
                $msgID = $event['msgID'];
                _event_PrivateMsg($CQ, $subType, $time, $msgID, $qq, $msg, $event);
                break;

            case 2:
                //收到群聊天信息
                $group = $event['group'];
                $qq = $event['qq'];
                $msg = $event['msg'];
                $msgID = $event['msgID'];
                _event_GroupMsg($CQ, $subType, $time, $msgID, $group, $qq, $msg, $event);
                break;

            case 4:
                //收到讨论组信息
                $group = $event['group'];
                $qq = $event['qq'];
                $msg = $event['msg'];
                $msgID = $event['msgID'];
                _event_DiscussMsg($CQ, $subType, $time, $msgID, $group, $qq, $msg, $event);
                break;

            case 11:
                //有群成员上传文件
                $group = $event['group'];
                $qq = $event['qq'];
                $file = $event['file'];
                _event_GroupFileUpload($CQ, $subType, $time, $group, $qq, $file, $event);
                break;

            case 101:
                //群管理员变动
                $group = $event['group'];
                $beingOperateQQ = $event['beingOperateQQ'];
                _event_GroupAdminChange($CQ, $subType, $time, $group, $beingOperateQQ, $event);
                break;

            case 102:
                //群成员减少
                $group = $event['group'];
                $qq = $event['qq'];
                $beingOperateQQ = $event['beingOperateQQ'];
                _event_GroupMemberDecrease($CQ, $subType, $time, $group, $qq, $beingOperateQQ, $event);
                break;

            case 103:
                //群成员增加
                $group = $event['group'];
                $qq = $event['qq'];
                $beingOperateQQ = $event['beingOperateQQ'];
                _event_GroupMemberIncrease($CQ, $subType, $time, $group, $qq, $beingOperateQQ, $event);
                break;

            case 201:
                //好友已添加
                $qq = $event['qq'];
                _event_FriendIsAdd($CQ, $subType, $time, $qq, $event);
                break;

            case 301:
                //请求添加好友
                $qq = $event['qq'];
                $msg = $event['msg'];
                $responseFlag = $event['responseFlag'];
                _event_RequestAddFriend($CQ, $subType, $time, $qq, $msg, $responseFlag, $event);
                break;

            case 302:
                //添加群请求
                $group = $event['group'];
                $qq = $event['qq'];
                $msg = $event['msg'];
                $responseFlag = $event['responseFlag'];
                _event_RequestAddGroup($CQ, $subType, $time, $group, $qq, $msg, $responseFlag, $event);
                break;
        }
        unset($event);
    }
}

treatEvent($CQ, $eventHeap); //解析事件数据
