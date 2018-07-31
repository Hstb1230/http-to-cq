<?php

if(!defined('SITE_PATH')) exit;

/**
 * 收到私聊消息
 * @event 1
 * @param CoolQ $CQ API Class
 * @param int $subType 消息子类型，11/来自好友 1/来自在线状态 2/来自群 3/来自讨论组
 * @param int $time 消息发送事件(10位时间戳)
 * @param int $msgID 消息ID
 * @param int $fromQQ 来源QQ
 * @param string $msg 消息内容
 * @param array $info 该事件的所有信息
 */
function _event_PrivateMsg(CoolQ $CQ, $subType, $time, $msgID, $fromQQ, $msg, array $info)
{
    /*
    $reply = "subType = $subType\n";
    $reply .= "time = $time\n";
    $reply .= "msgID = $msgID\n";
    $reply .= "fromQQ = $fromQQ\n";
    $reply .= "msg = $msg";
    $CQ->sendPrivateMsg($fromQQ, $reply);
    */
}

/**
 * 收到群消息
 * @event 2
 * @param CoolQ $CQ API Class
 * @param int $subType 消息子类型，1/普通消息 2/匿名消息 3/系统消息
 * @param int $time 消息发送时间(10位时间戳)
 * @param int $msgID 消息ID
 * @param int $fromGroup 来源群
 * @param int $fromQQ 来源QQ
 * @param string $msg 消息内容
 * @param array $info 该事件的所有信息
 */
function _event_GroupMsg(CoolQ $CQ, $subType, $time, $msgID, $fromGroup, $fromQQ, $msg, array $info)
{
    /*
    $reply = "subType = $subType\n";
    $reply .= "time = $time\n";
    $reply .= "msgID = $msgID\n";
    $reply .= "fromGroup = $fromGroup\n";
    $reply .= "fromQQ = $fromQQ\n";
    $reply .= "msg = $msg";
    $CQ->sendGroupMsg($fromGroup, $reply);
    */

    /*
    if($msg == '你好') {
        $CQ->sendGroupMsg($fromGroup, "你好\r\n我是小娜");
        $CQ->sendGroupMsg($fromGroup,'你是我的闺蜜Sir吗');
        $CQ->sendGroupMsg($fromGroup, $CQ->cqAt($fromQQ));
    }
    //撤回消息
    //$CQ->setMsgDelete($msgID);
    if($subType == 2) {
        //收到匿名消息
        $anonymousInfo = $info['anonymousInfo'];
        //$anonymousInfo['name']; //匿名用户代号
        //禁言匿名成员1分钟
        $CQ->setGroupAnonymousBan($fromGroup, $info['fromAnonymous'], 60);
    }
    */
}

/**
 * 收到讨论组消息
 * @event 4
 * @param CoolQ $CQ API Class
 * @param int $subType 消息子类型，该事件下固定为 1
 * @param int $time 消息发送时间(10位时间戳)
 * @param int $msgID 消息ID
 * @param int $fromDiscuss 来源讨论组号
 * @param int $fromQQ 来源QQ
 * @param string $msg 消息内容
 * @param array $info 该事件的全部信息
 */
function _event_DiscussMsg(CoolQ $CQ, $subType, $time, $msgID, $fromDiscuss, $fromQQ, $msg, array $info)
{
    /*
    $reply = "subType = $subType\n";
    $reply .= "time = $time\n";
    $reply .= "msgID = $msgID\n";
    $reply .= "fromDiscuss = $fromDiscuss\n";
    $reply .= "fromQQ = $fromQQ\n";
    $reply .= "msg = $msg";
    $CQ->sendDiscussMsg($fromDiscuss, $reply);
    */
}


/**
 * 群文件上传事件
 * @event 11
 * @param CoolQ $CQ API Class
 * @param int $subType 事件子类型，该事件下固定为 1
 * @param int $time 事件产生时间(10位时间戳)
 * @param int $fromGroup 来源群号
 * @param int $fromQQ 上传者QQ号
 * @param string $file 上传文件信息
 * @param array $info 该事件所有信息，包含解析后的文件信息 fileInfo
 */
function _event_GroupFileUpload(CoolQ $CQ, $subType, $time, $fromGroup, $fromQQ, $file, array $info)
{
    /*
    $fileInfo = $info['fileInfo'];
    $msg = $CQ->cqAt($fromQQ)."上传了文件\n";
    $msg .= '文件名：'.$fileInfo['name']."\n";
    $msg .= '文件大小：'.$fileInfo['size'].' B';
    $CQ->sendGroupMsg($fromGroup, $msg);
    */
    // 删除文件
    // $CQ->setGroupFileDelete($fromGroup, $fileInfo['busid'], $fileInfo['id']);
}


/**
 * 管理员变动事件
 * @event 101
 * @param CoolQ $CQ API Class
 * @param int $subType 事件子类型，1/被取消管理员 2/被设置管理员
 * @param int $time 事件产生时间(10位时间戳)
 * @param int $fromGroup 来源群号
 * @param int $beingOperateQQ 被操作QQ
 * @param array $info 该事件的所有信息
 */
function _event_GroupAdminChange(CoolQ $CQ, $subType, $time, $fromGroup, $beingOperateQQ, array $info)
{
    /*
    $msg = $CQ->cqAt($beingOperateQQ);
    $msg .= '被'.($subType == 1 ? '取消' : '设置为').'管理员';
    $CQ->sendGroupMsg($fromGroup, $msg);
    */
}


/**
 * 群成员减少事件
 * @event 102
 * @param CoolQ $CQ API Class
 * @param int $subType 事件子类型，1/群员退群 2/群员被踢
 * @param int $time 事件产生时间(10位时间戳)
 * @param int $fromGroup 来源群号
 * @param int $fromQQ 操作者QQ(仅subType==2时存在)
 * @param int $beingOperateQQ 退群者||被踢者
 * @param array $info 该事件的所有信息
 */
function _event_GroupMemberDecrease(CoolQ $CQ, $subType, $time, $fromGroup, $fromQQ, $beingOperateQQ, array $info)
{
    /*
    $msg = '';
    $qqInfo = $CQ->getStrangerInfo($beingOperateQQ);
    if($qqInfo['status'] == 0) {
        $qqInfo = $qqInfo['result'];
        $msg = $CQ->cqImage($qqInfo['headimg']);
    }
    $msg .= '有个群员';
    $msg .= ($subType == 1) ? '退群了' : '被踢了';
    $CQ->sendGroupMsg($fromGroup, $msg);
    */
}


/**
 * 群成员增加事件
 * @event 103
 * @param CoolQ $CQ API Class
 * @param int $subType 事件子类型，1/管理员已同意 2/管理员邀请
 * @param int $time 事件产生时间(10位时间戳)
 * @param int $fromGroup 来源群
 * @param int $fromQQ 操作者QQ(即管理员QQ)
 * @param int $beingOperateQQ 被操作QQ(即加群的QQ)
 * @param array $info 该事件的所有信息
 */
function _event_GroupMemberIncrease(CoolQ $CQ, $subType, $time, $fromGroup, $fromQQ, $beingOperateQQ, array $info)
{
    /*
    $msg = '欢迎'.$CQ->cqAt($beingOperateQQ);
    $groupTopNote = $CQ->getGroupTopNote($fromGroup);
    if($groupTopNote['status'] == 0 && !empty($groupTopNote['result'])) {
        $groupTopNote = $groupTopNote['result'];
        $msg .= "\n";
        $msg .= $groupTopNote['msg']['text'];
    }
    $CQ->sendGroupMsg($fromGroup, $msg);
    */
}


/**
 * 已添加好友事件
 * @event 201
 * @param CoolQ $CQ API Class
 * @param int $subType 事件子类型，在此事件中固定为 1
 * @param int $time 事件产生时间(10位时间戳)
 * @param int $fromQQ 添加好友的QQ
 * @param array $info 该事件的所有信息
 */
function _event_FriendIsAdd(CoolQ $CQ, $subType, $time, $fromQQ, array $info)
{
    /*
    $reply = '我们成为好友了，快来聊天吧';
    $CQ->sendPrivateMsg($fromQQ, $reply);
    */
}


/**
 * 事件_添加好友请求
 * @event 301
 * @param CoolQ $CQ API Class
 * @param int $subType 事件子类型，该事件下固定为 1
 * @param int $time 事件产生时间(10位时间戳)
 * @param int $fromQQ 发送添加好友请求的QQ
 * @param string $msg 附言
 * @param string $responseFlag 处理标识，调用api需要使用
 * @param array $info 该事件的所有信息
 */
function _event_RequestAddFriend(CoolQ $CQ, $subType, $time, $fromQQ, $msg, $responseFlag, array $info)
{
    //通过请求
    //$CQ->setFriendAddRequest($responseFlag, 1, '这是备注');
    //拒绝请求
    //$CQ->setFriendAddRequest($responseFlag, 2);
}


/**
 * 事件_添加群请求
 * @event 302
 * @param CoolQ $CQ API Class
 * @param int $subType 事件子类型，1/他人申请入群 2/自己(即机器人)受邀入群
 * @param int $time 事件产生时间(10位时间戳)
 * @param int $fromGroup 来源群号
 * @param int $fromQQ 发送请求的QQ
 * @param string $msg 加群理由
 * @param string $responseFlag 处理标识
 * @param array $info 该事件的全部信息
 */
function _event_RequestAddGroup(CoolQ $CQ, $subType, $time, $fromGroup, $fromQQ, $msg, $responseFlag, array $info)
{
    //通过请求
    //$CQ->setGroupAddRequest($responseFlag, $subType, 1);
    //拒绝请求
    //$CQ->setGroupAddRequest($responseFlag, $subType, 2, '拒绝理由');
}

