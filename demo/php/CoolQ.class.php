<?php

if(!defined('SITE_PATH')) exit;

define('module_api', 'api');
define('module_eventManage', 'eventManage');

trait CoolQ_static
{
    /**
     * 说明
     * 此class只用于获取特定CQ码，并没有真正的调用API！！！
     */

    /**
     * @某人(at)
     * @param number $qq 要艾特的QQ号，-1 为全体
     * @param bool $needSpace  At后不加空格，默认为 True，可使At更规范美观。如果不需要添加空格，请置本参数为 False。
     * @return string CQ码_At
     */
    public function cqAt($qq, $needSpace = true)
    {
        if($qq == -1) $qq = 'all';
        return $needSpace ? "[CQ:at,qq=$qq] " : "[CQ:at,qq=$qq]";
    }

    /**
     * 禁言
     * 只能在群消息中使用，
     * @param int $qq 禁言操作，-1为全体
     * @param int $time 禁言时间，0为解除禁言
     * @return string CQ码_At
     */
    public function cqBan($qq = -1, $time = 0)
    {
        return "[CQ:ban,qq=$qq,time=$time]";
    }

    /**
     * 发送emoji表情(emoji)
     * @param int $id 表情ID，emoji的unicode编号
     * @return string CQ码_emoji
     */
    public function cqEmoji($id)
    {
        return "[CQ:emoji,id=$id]";
    }

    /**
     * 发送表情(face)
     * @param int $id 表情ID，0 ~ 200+
     * @return string CQ码_表情
     */
    public function cqFace($id)
    {
        return "[CQ:face,id=$id]";
    }

    /**
     * 发送窗口抖动(shake) - 仅支持好友，腾讯已将其改名为戳一戳
     * @return string CQ码_窗口抖动
     */
    public function cqShake()
    {
        return '[CQ:shake]';
    }

    /**
     * 反转义
     * @param string $msg 原消息，要反转义的字符串
     * @return string 反转义后的字符串
     */
    public function antiEscape($msg)
    {
        $msg = str_replace('&#91;', '[', $msg);
        $msg = str_replace('&#93;', ']', $msg);
        $msg = str_replace('&#44;', ',', $msg);
        $msg = str_replace('&amp;', '&', $msg);
        return $msg;
    }

    /**
     * 发送链接分享(share)
     * @param string $url 分享链接，点击卡片后跳转的网页地址
     * @param string $title 标题，可空，分享的标题，建议12字以内
     * @param string $content 内容，可空，分享的简介，建议30字以内
     * @param string $picUrl 图片链接，可空，分享的图片链接，留空则为默认图片
     * @return string CQ码_链接分享
     */
    public function cqShare($url, $title = '', $content = '', $picUrl = '') //发送链接分享
    {
        $msg = '[CQ:share,url='.$this->escape($url, true);
        if($title) $msg .= ',title='.$this->escape($title, true);
        if($content) $msg .= ',content='.$this->escape($content, true);
        if($picUrl) $msg .= ',image='.$this->escape($picUrl, true);
        $msg .= ']';
        return $msg;
    }

    /**
     * 发送名片分享(contact)
     * @param string $type 分享类型，目前支持 qq/好友分享 group/群分享
     * @param number $id 分享帐号，类型为qq，则为QQ号；类型为group，则为群号
     * @return string CQ码_名片分享
     */
    public function cqCardShare($type = 'qq', $id)
    {
        $type = $this->escape($type, true);
        return "[CQ:contact,type=$type,id=$id]";
    }

    /**
     * 匿名发消息（anonymous），仅支持群
     * @param boolean $ignore 是否不强制，默认为 False。如果希望匿名失败时，将消息转为普通消息发送（而不是取消发送），请置本参数为 True
     * @return string CQ码_匿名
     */
    public function cqAnonymous($ignore = false)
    {
        return $ignore ? '[CQ:anonymous,ignore=true]' : '[CQ:anonymous]';
    }

    /**
     * CQ码_图片(image)
     * @param string $path 图片路径，可使用网络图片和本地图片．使用本地图片时需在路径前加入 file://
     * @return string CQ码_图片
     */
    public function cqImage ($path)
    {
        $path = $this->escape($path, true);
        return "[CQ:image,file=$path]";
    }

    /**
     * 取CQ码_位置分享(location)
     * @param double $lat 纬度
     * @param double $lon 经度
     * @param int $zoom 放大倍数，可空，默认为 15
     * @param string $title 地点名称，建议12字以内
     * @param string $content 地址，建议20字以内
     * @return string CQ码_位置分享
     */
    public function cqLocation ($lat, $lon, $zoom = 15, $title, $content)
    {
        $title = $this->escape($title, true);
        $content = $this->escape($content, true);
        return "[CQ:location,lat=$lat,lon=$lon,zoom=$zoom,title=$title,content=$content]";
    }

    /**
     * 取CQ码_音乐(music)
     * @param number $songID 音乐的歌曲数字ID
     * @param string $type 音乐网站类型，目前支持 qq/QQ音乐 163/网易云音乐 xiami/虾米音乐，默认为qq
     * @param bool $newStyle 是否启用新版样式，目前仅 QQ音乐 支持
     * @return string CQ码_音乐
     */
    public function cqMusic ($songID, $type = 'qq', $newStyle = false) //发送音乐
    {
        $type = $this->escape($type, true);
        $newStyle = $newStyle ? 1 : 0;
        return "[CQ:music,id=$songID,type=$type,style=$newStyle]";
    }

    /**
     * 取CQ码_音乐自定义分享(music)
     * @param string $url 分享链接，点击分享后进入的音乐页面（如歌曲介绍页）
     * @param string $audio 音频链接，音乐的音频链接（如mp3链接）
     * @param string $title 标题，可空，音乐的标题，建议12字以内
     * @param string $content 内容，可空，音乐的简介，建议30字以内
     * @param string $image 封面图片链接，可空，音乐的封面图片链接，留空则为默认图片
     * @return string CQ码_音乐自定义分享
     */
    public function cqCustomMusic($url, $audio, $title = '', $content = '', $image = '') //发送自定义音乐分享
    {
        $url = $this->escape($url, true);
        $audio = $this->escape($audio, true);
        $para = "[CQ:music,type=custom,url=$url,audio=$audio";
        if($title) $para .= ',title='.$this->escape($title, true);
        if($content) $para .= ',content='.$this->escape($content, true);
        if($image) $para .= ',image='.$this->escape($image, true);
        $para .= ']';
        return $para;
    }

    /**
     * 取CQ码_语音(record)
     * @param string $path 语音路径，可使用网络和本地语音文件．使用本地语音文件时需在路径前加入 file://
     * @return string CQ码_语音
     */
    public function cqRecord($path)
    {
        $path = $this->escape($path, true);
        return "[CQ:record,file=$path]";
    }

    /**
     * 转义
     * @param string $msg 要转义的字符串
     * @param boolean $escapeComma 转义逗号，默认不转义
     * @return string 转义后的字符串
     */
    public function escape ($msg, $escapeComma=false)
    {
        $msg = str_replace('[', '&#91;', $msg);
        $msg = str_replace(']', '&#93;', $msg);
        $msg = str_replace('&', '&amp;', $msg);
        if($escapeComma) $msg = str_replace(',', '&#44;', $msg);
        return $msg;
    }

    /**
     * 取CQ码_大表情(bface)
     * @param int $pID 大表情所属系列的标识
     * @param int $id 大表情的唯一标识
     * @return string CQ码_大表情
     */
    public function cqBigFace($pID, $id)
    {
        return "[CQ:bface,p=$pID,id=$id]";
    }

    /**
     * 取CQ码_小表情(sface)
     * @param int $id 小表情代码
     * @return string CQ码_小表情
     */
    public function cqSmallFace($id)
    {
        return "[CQ:sface,id=$id]";
    }

    /**
     * 取CQ码_厘米秀(show)
     * @param int $id 动作代码
     * @param number $qq 动作对象，可空，仅在双人动作时有效
     * @param string $content 消息内容，建议8个字以内
     * @return string CQ码_厘米秀
     */
    public function cqShow ($id, $qq = null, $content = '')
    {
        $msg = '[CQ:show,id='.$id;
        if($qq) $msg .= ',qq='.$qq;
        if($content) $msg .= ',content='.$this->escape($content, true);
        $msg .= ']';
        return $msg;
    }

}

trait CoolQ_core
{
    /**
     * 动态API与静态API混合版
     * 若API返回状态码，状态码为0时表示成功
     * 若API返回数组，
     *     则数组成员[Status]的值表示状态码，
     *     状态码为 0 时表示成功
     *     状态码为负值时表示失败，部分情况下存在表示错误原因的成员errMsg，
     *     若不存在成员errMsg，则参考酷Q官方文库：
     *     http://d.cqp.me/Pro/%E5%BC%80%E5%8F%91/Error
     * 若因网络因素无法成功调用API，则状态码[Status]为 -504
     * 如果不使用动态交互，即使用静态API，则部分API无法使用，此部分API调用时返回状态码 -501
     */

    use CoolQ_eventManage, CoolQ_get, CoolQ_other, CoolQ_send, CoolQ_set, CoolQ_static;
    protected $url, $key, $time, $format;

    /**
     * 销毁时调用
     */
    function __destruct()
    {
        echo "\r\n[]";
    }

    /**
     * 访问网页
     * @param string $url 请求网址
     * @param string $data 请求数据，非空时使用POST方法
     * @param string $cookies 可空
     * @param array $headers
     * @param string $proxy 代理地址，可空
     * @param int $time 超时时间，单位：秒。默认10秒
     * @return string 执行结果
     */
    protected function getHttpData($url, $data = '', $cookies = '', $headers = array(), $proxy = '', $time = 8)
    {
        $ch = curl_init($url); //初始化 CURL 并设置请求地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设置获取的信息以文件流的形式返回
        if($data) curl_setopt($ch, CURLOPT_POST, 1); //设置 post 方式提交
        if($data) curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //设置 post 数据
        if(is_array($cookies) && $cookies) {
            foreach ($cookies as $array) $data .= $array;
            $cookies = $data;
        }
        if($cookies) curl_setopt($ch, CURLOPT_COOKIE, $cookies);   //设置Cookies
        if($headers) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if($proxy) curl_setopt ($ch, CURLOPT_USERAGENT, $proxy);
        curl_setopt($ch, CURLOPT_TIMEOUT, $time);   //只需要设置一个秒的数量就可以
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在

        $data = curl_exec($ch); //执行命令
        curl_close($ch); //关闭 CURL

        return $data;
    }

    /**
     * 获取资源统一方法
     * 此方法不公开
     * @param string $type 函数名
     * @param string $source 资源ID
     * @param string $format 文件格式
     * @return array
     */
    protected function getSource($type, $source, $format = '')
    {
        $arr = $this->newArray(module_api, $type);
        $arr['source'] = $source;
        if($format) $arr['format'] = $format;
        return $this->sendData($arr);
    }

    /**
     * 构造数组
     * 此方法不公开
     * @param string $module 模块名
     * @param string $fun 函数名
     * @param string $groupID group/discussID
     * @param string $qq
     * @param string $msg
     * @return array
     */
    protected function newArray($module, $fun, $groupID = '', $qq = '', $msg = '')
    {
        $arr = ['module' => $module, 'fun' => $fun];
        if($groupID) $arr['group'] = $groupID;
        if($qq) $arr['qq'] = $qq;
        if($msg) $arr['msg'] = $msg;
        return $arr;
    }

    /**
     * 发送数据给服务器,并获取返回内容
     * @param array $arr 发送给服务器的数据
     * @param int $time_out 超时时间，单位/秒，默认为8
     * @return array 从服务器获取到的信息
     */
    protected function sendData($arr, $time_out = 8)
    {
        if(!$this->url) {
            if($arr['module'] = module_api && preg_match('/(send|set|addLog|rebootService)/i', $arr['fun'])) {
                echo json_encode($arr)."\r\n";
                $arr = ['status' => 0];
            } else $arr = ['status' => -501, 'errMsg' => '因策略原因，无法调用此API'];
            return $arr;
        }
        if($this->key) {
            $arr['authTime'] = time();
            $arr['authToken'] = md5($this->key . ':' . $arr['authTime']);
        }
        $get = $this->getHttpData($this->url, json_encode($arr), null, null, null, $time_out);
        $arr = json_decode($get, true);
        if(!empty($arr)) unset($arr['request']);
        if(defined('CoolQ_Debug')) echo json_encode($arr)."\n";
        if(empty($arr)) $arr = ['status' => -504, 'errMsg' => '无法连接到服务端'];
        return $arr;
    }

    /**
     * 获取无参数API统一方法
     * 此方法不公开
     * @param string $type 函数名
     * @return array
     */
    protected function getNoParamReturn($type)
    {
        return $this->sendData($this->newArray(module_api, $type));
    }

}

trait CoolQ_get
{

    /**
     * 取匿名成员信息
     * @param string $source 匿名成员的标识
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该匿名成员的信息
     */
    public function getAnonymousInfo($source)
    {
        return $this->getSource(__FUNCTION__, $source);
    }

    /**
     * 获取权限信息
     * 返回值包括 AuthCode，Cookies，CSRFToken
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：AuthInfo
     */
    public function getAuthInfo()
    {
        return $this->getNoParamReturn(__FUNCTION__);
    }

    /**
     * 取指定群中被禁言用户列表
     * 需要机器人具有管理身份
     * @auth 20
     * @param number $group 目标群
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群中被禁言的用户列表
     */
    public function getBanList($group)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $group);
        return $this->sendData($arr);
    }

    /**
     * 取群文件信息
     * @param string $source 文件标识
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该文件的文件属性
     */
    public function getFileInfo($source)
    {
        return $this->getSource(__FUNCTION__, $source);
    }

    /**
     * 取好友列表
     * @auth 20
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：当前机器人所加的好友信息列表
     */
    public function getFriendList()
    {
        return $this->getNoParamReturn(__FUNCTION__);
    }

    /**
     * 取群作业列表
     * @auth 20
     * @param number $groupID 目标群
     * @param int $number 取出数量
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的作业列表(不存在未指定给机器人查看的作业)
     */
    public function getGroupHomeworkList($groupID, $number = 10)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $groupID);
        $arr['number'] = $number;
        return $this->sendData($arr);
    }

    /**
     * 取群详细信息
     * @auth 20
     * @param number $groupID 目标群
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的详细信息
     */
    public function getGroupInfo($groupID)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $groupID);
        return $this->sendData($arr);
    }

    /**
     * 取群链接列表
     * @auth 20
     * @param number $groupID 目标群
     * @param int $number 数量，默认 10
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：在该群中发过的链接列表
     */
    public function getGroupLinkList($groupID, $number = 10)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $groupID);
        $arr['number'] = $number;
        return $this->sendData($arr);
    }

    /**
     * 获取群列表
     * @auth 161
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：目前机器人所加入的群列表信息
     */
    public function getGroupList()
    {
        return $this->getNoParamReturn(__FUNCTION__);
    }

    /**
     * 取群成员信息
     * @auth 130, 20
     * @param number $group 目标所在群
     * @param number $qq 目标QQ
     * @param bool $useCache 不使用缓存，True/使用 False/不使用，默认为 False
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群指定群成员的个人信息
     */
    public function getGroupMemberInfo($group, $qq, $useCache = true)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $group, $qq);
        $arr['cache'] = $useCache;
        return $this->sendData($arr);
    }

    /**
     * 取群成员列表
     * @auth 160
     * @param number $groupID 目标群
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的群成员列表
     */
    public function getGroupMemberList($groupID)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $groupID);
        return $this->sendData($arr);
    }

    /**
     * 取群公告列表
     * @auth 20
     * @param number $groupID 目标群
     * @param int $number 公告数量，默认 10
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的公告列表
     */
    public function getGroupNoteList($groupID, $number = 10)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $groupID);
        $arr['number'] = $number;
        return $this->sendData($arr);
    }

    /**
     * 取群置顶公告
     * @auth 20
     * @param number $groupID 目标群
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的置顶公告(本群须知)信息
     */
    public function getGroupTopNote($groupID)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $groupID);
        return $this->sendData($arr);
    }

    /**
     * 获取图片信息
     * @param string $path 图片文件名，不带路径，并且必须是酷Q收到的图片
     * @param boolean $needFile 回传文件内容，默认为True
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该图片信息
     */
    public function getImageInfo($path, $needFile = true)
    {
        $arr = $this->newArray(module_api, __FUNCTION__);
        $arr['source'] = $path;
        $arr['needFile'] = $needFile;
        return $this->sendData($arr);
    }

    /**
     * 取登录QQ信息
     * 该API可能需要获取Cookies权限
     * @auth 20
     * @return array 登录QQ的信息
     */
    public function getLoginQQInfo()
    {
        return $this->getNoParamReturn(__FUNCTION__);
    }

    /**
     * 批量取群头像
     * @auth 20，161
     * @param string $groupList 群列表，每个群用 - 分开，可空，参数值为空时，取所有群的头像
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：所提供的群号的头像链接列表
     */
    public function getMoreGroupHeadImg($groupList = '')
    {
        $arr = $this->newArray(module_api, __FUNCTION__);
        $arr['groupList'] = $groupList;
        return $this->sendData($arr);
    }

    /**
     * 批量取QQ信息
     * @auth 20
     * @param string $qqList QQ列表，每个QQ用 - 分开
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：所提供的QQ的信息列表
     */
    public function getMoreQQInfo($qqList)
    {
        $arr = $this->newArray(module_api, __FUNCTION__);
        $arr['qqList'] = $qqList;
        return $this->sendData($arr);
    }

    /**
     * 接收消息中的语音(record)
     * @auth 30
     * @param string $fileName 文件名，收到消息中的语音文件名(file)
     * @param string $format 转码成何种音频文件，目前支持 mp3,amr,wma,m4a,spx,ogg,wav,flac，默认 mp3
     * @param boolean $needFile 是否回传文件数据，默认为True
     * @return string 成功时，数组中成员Status的值为0，并在成员Result中返回：该语音文件的信息(文件名，内容)
     */
    public function getRecord($fileName, $format = 'mp3', $needFile = true)
    {
        $arr = $this->newArray(module_api, __FUNCTION__);
        $arr['source'] = $fileName;
        $arr['format'] = $format;
        $arr['needFile'] = $needFile;
        return $this->sendData($arr);
    }

    /**
     * 取软件状态
     * 向服务端发送一条消息，确认是否奔溃
     * @param int $time 最长等待时间，单位/秒，默认为3
     * @return bool 运行正常返回 True，奔溃情况下返回 False
     */
    public function getRunStatus($time = 3)
    {
        $arr = $this->newArray(module_api, __FUNCTION__);
        $arr = $this->sendData($arr, $time);
        return (!$arr['status']) ? true : false;
    }

    /**
     * 取群文件列表
     * @auth 20
     * @param number $groupID 目标群
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的群文件信息列表
     */
    public function getShareList($groupID)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $groupID);
        return $this->sendData($arr);
    }

    /**
     * 取群签到列表
     * @auth 20
     * @param number $groupID 目标群
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的群签到信息
     */
    public function getSignList($groupID)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $groupID);
        return $this->sendData($arr);
    }

    /**
     * 取陌生人信息
     * @auth 131,20
     * @param number $qq 目标QQ
     * @param bool $useCache 不使用缓存，True/使用 False/不使用，默认为 False
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该QQ的部分个人信息
     */
    public function getStrangerInfo($qq, $useCache = true)
    {
        $arr = $this->newArray(module_api, __FUNCTION__.'_V2', null, $qq);
        $arr['cache'] = $useCache;
        return $this->sendData($arr);
    }

    /**
     * 取版本信息
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：酷Q版本(air/pro)、插件版本
     */
    public function getVersion()
    {
        return $this->getNoParamReturn(__FUNCTION__);
    }

    /**
     * 取运行信息
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：相关的运行信息
     */
    public function getRunningInfo()
    {
        return $this->getNoParamReturn(__FUNCTION__);
    }

}

trait CoolQ_send
{

    /**
     * 发送消息统一方法
     * 此方法不公开
     * @param string $type 函数名，Private/私聊、Group/群、Discuss/讨论组
     * @param int $groupID GroupID / DiscussID
     * @param int $qq
     * @param string $msg
     * @return int 成功时返回消息ID，失败时返回状态码(负值)
     */
    protected function sendMsg($type, $groupID = 0, $qq = 0, $msg)
    {
        $fun = 'send'.$type.'Msg';
        $arr = $this->newArray(module_api, $fun, $groupID, $qq, $msg);
        $arr = $this->sendData($arr);
        if(!$arr['status']) {
            if((!isset($arr['result']))) $arr['result'] = 0; // 因为发送某些CQ码时并不触发消息，所以不返回消息ID
            return $arr['result'];
        }
        return $arr['status'];
    }

    /**
     * 发送讨论组信息
     * @auth 103
     * @param number $discuss 目标讨论组
     * @param string $msg 消息内容
     * @return int 成功时返回消息ID，失败时返回状态码(负值)
     */
    public function sendDiscussMsg($discuss, $msg)
    {
        return $this->sendMsg('Discuss', $discuss, null, $msg);
    }

    /**
     * 送花
     * 需要账户中有金豆
     * @auth 20
     * @param number $group 群号
     * @param number $qq QQ号
     * @return int 状态码
     */
    public function sendFlower($group, $qq)
    {
        $array = $this->newArray(module_api, __FUNCTION__, $group, $qq);
        $array = $this->sendData($array);
        return $array['status'];
    }

    /**
     * 发送群消息
     * @auth 101
     * @param number $group 目标群
     * @param string $msg 消息内容
     * @return int 成功时返回消息ID，失败时返回状态码(负值)
     */
    public function sendGroupMsg($group, $msg)
    {
        return $this->sendMsg('Group', $group, null, $msg);
    }

    /**
     * 发送手机赞
     * @auth 110
     * @param number $qq 目标QQ
     * @param int $count 赞的次数，最多10次，默认为1次
     * @return int 状态码
     */
    public function sendLike($qq, $count = 1) //发送赞
    {
        $arr = $this->newArray(module_api, __FUNCTION__, null, $qq);
        $arr['number'] = $count;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 发送私聊信息
     * @auth 106
     * @param number $qq 目标QQ
     * @param string $msg 消息内容
     * @return int 成功时返回消息ID，失败时返回状态码(负值)
     */
    public function sendPrivateMsg($qq, $msg)
    {
        return $this->sendMsg('Private', null, $qq, $msg);
    }

}

trait CoolQ_set
{

    /**
     * 用于操作事务的API
     */

    /**
     * 置讨论组退出
     * @auth 140
     * @param number $discuss 目标讨论组号
     * @return int 状态码
     */
    public function setDiscussLeave($discuss)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $discuss);
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置好友添加请求
     * @auth 150
     * @param string $responseFlag 反馈标识，请求事件收到的"$responseFlag"参数
     * @param int $subType 反馈类型，1/通过 2/拒绝
     * @param string $name 添加后的好友备注
     * @return int 状态码
     */
    public function setFriendAddRequest($responseFlag, $subType, $name = '')
    {
        $arr = $this->newArray(module_api, __FUNCTION__);
        $arr['responseFlag'] = $responseFlag;
        $arr['subType'] = $subType;
        $arr['name'] = $name;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置群添加请求
     * @auth 151
     * @param string $responseFlag 反馈标识,请求事件收到的"$responseFlag"参数
     * @param int $subType 请求类型，1/群添加 2/群邀请
     * @param int $type 反馈类型，1/通过 2/拒绝
     * @param string $msg 操作理由，可空，仅 群添加 & 拒绝 情况下有效
     * @return int 状态码
     */
    public function setGroupAddRequest($responseFlag, $subType, $type, $msg = '')
    {
        $arr = $this->newArray(module_api, __FUNCTION__);
        $arr['responseFlag'] = $responseFlag;
        $arr['subType'] = $subType;
        $arr['type'] = $type;
        $arr['msg'] = $msg;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置群管理员
     * @auth 122
     * @param number $group 目标所在群
     * @param number $qq 目标QQ
     * @param bool $become 操作类型，True/设置管理员 False/取消管理员
     * @return int 状态码
     */
    public function setGroupAdmin($group, $qq, $become = false)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $group, $qq);
        $arr['become'] = $become;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置群匿名设置
     * @auth 125
     * @param number $group 目标群
     * @param bool $open 操作类型，True/开启匿名 False/关闭匿名
     * @return int 状态码
     */
    public function setGroupAnonymous($group, $open = false)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $group);
        $arr['open'] = $open;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置匿名群员禁言
     * @auth 124
     * @param number $group 目标所在群
     * @param string $anonymous 匿名标识，群消息事件收到的"$fromAnonymous"参数
     * @param int $time 禁言时间，单位为秒。不支持解禁
     * @return int 状态码
     */
    public function setGroupAnonymousBan($group, $anonymous, $time)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $group);
        $arr['anonymous'] = $anonymous;
        $arr['time'] = $time;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置群成员禁言
     * @auth 121, 123
     * @param int $group 目标所在群
     * @param int $qq 目标QQ，可空，空时为禁言全群
     * @param int $time 禁言的时间，单位为秒，可空。如果要解禁，这里填写 0；不得超过 2592000 (一个月)。禁言全群时，0为关闭，其余值为开启。
     * @return int 状态码
     */
    public function setGroupBan($group, $qq = 0, $time = 0)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $group, $qq);
        if($qq) $arr['time'] = $time; //禁言群成员
        else    $arr['open'] = (bool)$time; //更改全群禁言状态
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置群成员名片
     * @auth 126
     * @param number $group 目标所在群
     * @param number $qq 目标QQ
     * @param string $card 新名片
     * @return int 状态码
     */
    public function setGroupCard($group, $qq, $card = '')
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $group, $qq);
        $arr['card'] = $card;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 删除群文件
     * @auth 20
     * @param number $group 目标所在群
     * @param number $busid 未知作用，值为群文件信息中的```busid```
     * @param string $id 文件ID，值为群文件信息中的```id```
     * @return int 状态码，成功为0
     */
    public function setGroupFileDelete($group, $busid, $id)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $group);
        $arr['busid'] = $busid;
        $arr['id'] = $id;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置群退出
     * @auth 127
     * @param number $group 目标群
     * @param bool $disband 操作类型，True/解散本群(群主) False/退出本群(管理、群成员)，默认为 False
     * @return int 状态码
     */
    public function setGroupLeave($group, $disband = false)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $group);
        $arr['disband'] = $disband;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置成员移除
     * @auth 120
     * @param number $group 目标所在群
     * @param number $qq 目标QQ
     * @param bool $refuseJoin 拒绝再加群，True/不再接收此人加群申请，默认为 False
     * @return int 状态码
     */
    public function setGroupKick($group, $qq, $refuseJoin = false)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $group, $qq);
        $arr['refuseJoin'] = $refuseJoin;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置群签到
     * @auth 20
     * @param int $group 群号，可空，空时签到所有群
     * @return array 成功时，数组中成员Status的值为 0，并在成员Result中返回：本次签到成功的群数量
     */
    public function setGroupSign($group = 0)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $group);
        return $this->sendData($arr);
    }
    
    /**
     * 置群成员专属头衔 - 需群主权限
     * @auth 128
     * @param number $group 目标所在群
     * @param number $qq 目标QQ
     * @param string $tip 头衔，可空。如果要删除，这里填空
     * @param int $time 专属头衔有效期，单位为秒，可空。如果永久有效，这里填写-1
     * @return int 状态码
     */
    public function setGroupSpecialTitle($group, $qq, $tip = '', $time = -1)
    {
        $arr = $this->newArray(module_api, __FUNCTION__, $group, $qq);
        $arr['tip'] = $tip;
        $arr['time'] = $time;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置全群禁言
     * @auth 123
     * @param number $group 目标群
     * @param bool $open 开启禁言，True/开启 False/关闭，默认为 False
     * @return int 状态码
     */
    public function setGroupWholeBan($group, $open = false)
    {
        return $this->setGroupBan($group, null, (int)$open);
    }

    /**
     * 撤回消息
     * 说明：
     * 需要使用 酷Q Pro
     * 可以撤回群成员消息，但是需要群管理权限
     * 可以撤回自己发送消息，但只能撤回**两分钟**内发送的内容
     * @auth 180
     * @param int $msgID 消息ID
     * @return int 状态码
     */
    public function setMsgDelete($msgID)
    {
        $arr = $this->newArray(module_api, __FUNCTION__);
        $arr['msgID'] = $msgID;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置QQ打卡
     * 调用此API时，需要机器人QQ完成财付通实名认证
     * @auth 20
     * @return array 成功时，数组中成员Status的值为 0，并在成员Result中返回：本次签到的额外信息
     */
    public function setSign()
    {
        return $this->getNoParamReturn(__FUNCTION__);
    }

    /**
     * 设置悬浮窗信息
     * @param string $data 数据内容
     * @param string $unit 数据单位
     * @param int $color 颜色，1/绿 2/橙 3/红 4/深红 5/黑 6/灰
     * @return string 悬浮窗文本，无用
     */
    public function setStatus($data, $unit, $color)
    {
        $arr = $this->newArray(module_api, __FUNCTION__);
        $arr['data'] = $data;
        $arr['unit'] = $unit;
        $arr['color'] = $color;
        $arr = $this->sendData($arr);
        return (!$arr['status']) ? $arr['result'] : '';
    }


}

trait CoolQ_other
{
    public static $log_debug = 0; // 调试
    public static $log_info = 10; // 信息
    public static $log_infoSuccess = 11; // 信息_成功
    public static $log_infoReceive = 12; // 信息_接收
    public static $log_infoSend = 13; // 信息_发送
    public static $log_warming = 20; // 警告
    public static $log_error = 30; //错误
    public static $log_fatal = 40; //致命错误


    /**
     * 添加日志
     * @param int $level 优先级，请使用 log_ 开头的常量，如 $CQ->log_debug
     * @param string $type 日志类型
     * @param string $text 日志内容
     * @return array 成功时，数组中成员Status的值为0，Result为日志ID
     */
    public function addLog($level = 0, $type = '', $text = '')
    {
        $arr = $this->newArray(module_api, __FUNCTION__);
        $arr['level'] = $level;
        $arr['type'] = $type;
        $arr['text'] = $text;
        return $this->sendData($arr);
    }

    /**
     * 下载文件
     * @param string $url 文件的URL地址
     * @param string $name 文件名，可空，为空时使用md5值
     * @param int $type 文件类型，可空，1/图片 2/语音，默认为 1
     * @param string $md5 传入32位小写的文件校验码，可空，未传入时不校验文件
     * @return array 成功时，数组中成员Status的值为0，Result为文件的相对路径
     */
    public function downFile($url, $name = '', $type = 1, $md5 = '')
    {
        $arr = $this->newArray(module_api, __FUNCTION__);
        $arr['url'] = $url;
        $arr['name'] = $name;
        $arr['type'] = $type;
        $arr['md5'] = $md5;
        return $this->sendData($arr);
    }

    /**
     * 重启服务
     * 需先创建快速登录文件
     * 当酷Q崩溃(指无响应)时无法使用
     * 此API执行成功时状态码为-2
     * @return array
     */
    public function rebootService()
    {
        return $this->getNoParamReturn(__FUNCTION__);
    }

}

trait CoolQ_eventManage
{
    /**
     * 接收数据
     * 此方法用于接收并处理消息事件数据
     * @param string $from 来源类型，push/插件推送、obtain/从插件获取
     * @param int $limit 取回的事件数量，用于 obtain
     * @return array push：成功时返回消息信息，失败时返回一个空数组；obtain：成功时，数组中成员status的值为0，result为事件数据
     */
    public function receive($from = 'push', $limit = 5)
    {
        if($from == 'push') {
            //通过http推送
            switch ($this->format) {
                case 'JSON':
                    $arr = json_decode(urldecode(file_get_contents('php://input')), true);
                     break;
                case 'KV':
                    $arr = $_POST;
                    if (isset($arr['fileInfo'])) $arr['fileInfo'] = json_decode($arr['fileInfo'], true);
                    if (isset($arr['imageInfo'])) $arr['imageInfo'] = json_decode($arr['imageInfo'], true);
                    if (isset($arr['anonymousInfo'])) $arr['anonymousInfo'] = json_decode($arr['anonymousInfo'], true);
                    break;
                default:
                    if (defined('CoolQ_Debug')) echo "不支持的数据格式\r\n";
                    $arr = array();
            }
            if ($this->key) {
                if (isset($arr['authTime']) && isset($arr['authToken'])) {
                    $time = $arr['authTime'];
                    if (time() - $time <= $this->time) {
                        $token = strtolower($arr['authToken']);
                        if ($token == md5($this->key . ':' . $time)) {
                            unset($arr['authTime'], $arr['authToken']);
                        } else {
                            if (defined('CoolQ_Debug')) echo "传上来的authToken有问题\r\n";
                            $arr = array();
                        }
                    } else {
                        if (defined('CoolQ_Debug')) echo "传上来的时间过期\r\n";
                        $arr = array();
                    }
                } else {
                    if (defined('CoolQ_Debug')) echo "未传递校验参数\r\n";
                    $arr = [];
                }
            }
        }
        else if($from == 'obtain') {
            //从动态交互服务器中获取
            $arr = $this->newArray(module_eventManage, 'get');
            $arr['limit'] = $limit;
            $arr = $this->sendData($arr);
        }
        else $arr = [];
        return $arr;
    }
}

class CoolQ
{
    use CoolQ_core;

    /**
     * CoolQ constructor.
     * @param string $url 主机信息
     * @param string $key 数据校验所需 Key
     * @param int $time 数据有效时间
     * @param string $format 数据格式
     */
    function __construct($url = '', $key = '', $time = 30, $format = 'JSON')
    {
        $this->url = $url;
        $this->key = $key;
        $this->time = $time;
        $this->format = $format;
    }

}