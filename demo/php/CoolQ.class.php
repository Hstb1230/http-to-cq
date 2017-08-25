<?php

if (!defined('SITE_PATH')) exit;

class static_CoolQ
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
    public function sendAt($qq, $needSpace=true)
    {
        if($qq==-1) $qq = 'all';
        return $needSpace?"[CQ:at,qq=$qq] ":"[CQ:at,qq=$qq]";
    }

    /**
     * 发送Emoji表情(emoji)
     * @param int $id 表情ID，emoji的unicode编号
     * @return string CQ码_emoji
     */
    public function sendEmoji($id)
    {
        return "[CQ:emoji,id=$id]";
    }

    /**
     * 发送表情(face)
     * @param int $id 表情ID，0 ~ 200+
     * @return string CQ码_表情
     */
    public function sendFace($id)
    {
        return "[CQ:face,id=$id]";
    }

    /**
     * 发送窗口抖动(shake) - 仅支持好友，腾讯已将其改名为戳一戳
     * @return string CQ码_窗口抖动
     */
    public function sendShake()
    {
        return '[CQ:shake]';
    }

    /**
     * 反转义
     * @param string $msg 原消息，要反转义的字符串
     * @return string 反转义后的字符串
     */
    public function antiEscape ($msg)
    {
        $msg = str_replace('&#91;','[',$msg);
        $msg = str_replace('&#93;',']',$msg);
        $msg = str_replace('&#44;',',',$msg);
        $msg = str_replace('&amp;','&',$msg);
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
    public function sendShare($url,$title='',$content='',$picUrl='') //发送链接分享
    {

        $msg = '[CQ:share,url='.$this->escape($url,true);
        if ($title) $msg .= ',title='.$this->escape($title,true);
        if ($content) $msg .= ',content='.$this->escape($content,true);
        if ($picUrl) $msg .= ',image='.$this->escape($picUrl,true);
        return $msg.']';
    }

    /**
     * 发送名片分享(contact)
     * @param string $type 分享类型，目前支持 qq/好友分享 group/群分享
     * @param number $id 分享帐号，类型为qq，则为QQ号；类型为group，则为群号
     * @return string CQ码_名片分享
     */
    public function sendCardShare($type='qq', $id)
    {
        $type = $this->escape($type,true);
        return "[CQ:contact,type$type,id=$id]";
    }

    /**
     * 匿名发消息（anonymous），仅支持群
     * @param boolean $ignore 是否不强制，默认为 False。如果希望匿名失败时，将消息转为普通消息发送（而不是取消发送），请置本参数为 True
     * @return string CQ码_匿名
     */
    public function sendAnonymous($ignore=false)
    {
        return $ignore ? '[CQ:anonymous,ignore=true]' : '[CQ:anonymous]';
    }

    /**
     * CQ码_图片(image)
     * @param string $path 图片路径，可使用网络图片和本地图片．使用本地图片时需在路径前加入 file://
     * @return string CQ码_图片
     */
    public function sendImage ($path)
    {
        $path = $this->escape($path,true);
        return "[CQ:image,file=$path]";
    }

    /**
     * 发送位置分享(location)
     * @param double $lat 纬度
     * @param double $lon 经度
     * @param int $zoom 放大倍数，可空，默认为 15
     * @param string $title 地点名称，建议12字以内
     * @param string $content 地址，建议20字以内
     * @return string CQ码_位置分享
     */
    public function sendLocation ($lat, $lon, $zoom=15, $title, $content)
    {
        $title = $this->escape($title,true);
        $content = $this->escape($content,true);
        return "[CQ:location,lat=$lat,lon=$lon,zoom=$zoom,title=$title,content=$content]";
    }

    /**
     * 发送音乐(music)
     * @param number $songID 音乐的歌曲数字ID
     * @param string $type 音乐网站类型，目前支持 qq/QQ音乐 163/网易云音乐 xiami/虾米音乐，默认为qq
     * @param bool $newStyle 是否启用新版样式，目前仅 QQ音乐 支持
     * @return string CQ码_音乐
     */
    public function sendMusic ($songID, $type='qq', $newStyle=false) //发送音乐
    {
        $type = $this->escape($type,true);
        $newStyle = $newStyle ? 1 : 0;
        return "[CQ:music,id=$songID,type=$type,style=$newStyle]";
    }

    /**
     * 发送音乐自定义分享(music)
     * @param string $url 分享链接，点击分享后进入的音乐页面（如歌曲介绍页）
     * @param string $audio 音频链接，音乐的音频链接（如mp3链接）
     * @param string $title 标题，可空，音乐的标题，建议12字以内
     * @param string $content 内容，可空，音乐的简介，建议30字以内
     * @param string $image 封面图片链接，可空，音乐的封面图片链接，留空则为默认图片
     * @return string CQ码_音乐自定义分享
     */
    public function sendCustomMusic($url, $audio, $title='', $content='', $image='') //发送自定义音乐分享
    {
        $url = $this->escape($url,true);
        $audio = $this->escape($audio,true);
        $para = "[CQ:music,type=custom,url=$url,audio=$audio";
        if($title) $para .= ',title='.$this->escape($title,true);
        if($content) $para .= ',content='.$this->escape($content,true);
        if($image) $para .= ',image='.$this->escape($image,true);
        return $para.']';
    }

    /**
     * 发送语音(record)
     * @param string $path 语音路径，可使用网络和本地语音文件．使用本地语音文件时需在路径前加入 file://
     * @return string CQ码_语音
     */
    public function sendVoice ($path)
    {
        $path = $this->escape($path,true);
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
        $msg = str_replace('[','&#91;',$msg);
        $msg = str_replace(']','&#93;',$msg);
        $msg = str_replace('&','&amp;',$msg);
        if ($escapeComma) $msg = str_replace(',','&#44;',$msg);
        return $msg;
    }

    /**
     * 发送大表情(bface)
     * @param int $pID 大表情所属系列的标识
     * @param int $id 大表情的唯一标识
     * @return string CQ码_大表情
     */
    public function sendBigFace($pID, $id)
    {
        return "[CQ:bface,p=$pID,id=$id]";
    }

    /**
     * 发送小表情(sface)
     * @param int $id 小表情代码
     * @return string CQ码_小表情
     */
    public function sendSmallFace($id)
    {
        return "[CQ:sface,id=$id]";
    }

    /**
     * 发送厘米秀(show)
     * @param int $id 动作代码
     * @param number $qq 动作对象，可空，仅在双人动作时有效
     * @param string $content 消息内容，建议8个字以内
     * @return string CQ码_厘米秀
     */
    public function sendShow ($id, $qq=null, $content='')
    {
        $msg = '[CQ:show,id='.$id;
        if ($qq) $msg .= ',qq='.$qq;
        if ($content) $msg .= ',content='.$this->escape($content,true);
        return $msg.']';
    }

}

class core_CoolQ extends static_CoolQ
{
    /**
     * 动态API
     * 若API返回状态码，状态码为0时表示成功
     * 若API返回数组，
     *     则数组成员[Status]的值表示状态码，
     *     状态码为 0 时表示成功
     *     状态码为负值时表示失败，部分情况下存在表示错误原因的成员errmsg，
     *     若不存在成员errMsg，则参考酷Q官方文库：
     *     http://d.cqp.me/Pro/%E5%BC%80%E5%8F%91/Error
     * 若因网络因素无法成功调用API，则状态码[Status]为 -504
     */

    protected $add,$useCheck,$key,$time,$format;

    function __construct($add, $useCheck=false, $key='',$time = 30, $format='JSON') {
        $this->add = $add;
        $this->useCheck = $useCheck;
        $this->key = $key;
        $this->time = $time;
        $this->format = $format;
    }

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
    protected function getHttpData($url, $data='', $cookies='', $headers=array(),$proxy='',$time=8)
    {
        $ch = curl_init($url); //初始化 CURL 并设置请求地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设置获取的信息以文件流的形式返回
        if($data) curl_setopt($ch, CURLOPT_POST, 1); //设置 post 方式提交
        if($data) curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //设置 post 数据
        if(is_array($cookies) && $cookies) {
            foreach ($cookies as $array) $data .= $array;
            $cookies = $data;
        }
        if($cookies) curl_setopt($ch, CURLOPT_COOKIE,$cookies);   //设置Cookies
        if($headers) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if($proxy) curl_setopt ($ch, CURLOPT_USERAGENT, $proxy);
        curl_setopt($ch, CURLOPT_TIMEOUT,$time);   //只需要设置一个秒的数量就可以
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
    protected function getSource($type, $source, $format='')
    {
        $arr = $this->newArray($type);
        $arr['source'] = $source;
        if($format) $arr['format'] = $format;
        return $this->sendData($arr);
    }

    /**
     * 构造数组
     * 此方法不公开
     * @param string $type 函数名
     * @param string $groupID group/discussID
     * @param string $qq
     * @param string $msg
     * @return array
     */
    protected function newArray($type, $groupID='', $qq='', $msg='')
    {
        $arr = array('fun'=>$type);
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
    protected function sendData($arr,$time_out=8)
    {
        if($this->useCheck) {
            $arr['authTime'] = time();
            $arr['authToken'] = md5($this->key.':'.$arr['authTime']);
        }
        $get = $this->getHttpData($this->add,json_encode($arr),'','','',$time_out);
        $arr = json_decode($get,true);
        return (!empty($arr)) ? $arr : array('status'=>-504,'errmsg'=>'无法连接到服务端');
    }

    /**
     * 发送消息统一方法
     * 此方法不公开
     * @param string $type 函数名
     * @param int $groupID Group/DiscussID
     * @param int $qq
     * @param string $msg
     * @return int 状态码
     */
    protected function sendMsg($type, $groupID=0, $qq=0, $msg)
    {
        $arr = $this->newArray($type,$groupID,$qq,$msg);
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 获取无参数API统一方法
     * 此方法不公开
     * @param string $type 函数名
     * @return array
     */
    protected function getNoParamReturn($type)
    {
        return $this->sendData(array('fun'=>$type));
    }

    /**
     * 接收数据
     * 此方法用于接收插件推送的数据
     * @return array 成功时返回消息信息数组，失败时返回一个空数组
     */
    public function receive()
    {
        switch($this->format) {
            case 'JSON':
                $arr = json_decode(urldecode(file_get_contents('php://input')),true);
                break;
            case 'KV':
                $arr = $_POST;
                if(isset($arr['fileInfo'])) $arr['fileInfo'] = json_decode($arr['fileInfo'],true);
                if(isset($arr['imageInfo'])) $arr['imageInfo'] = json_decode($arr['imageInfo'],true);
                if(isset($arr['anonymousInfo'])) $arr['anonymousInfo'] = json_decode($arr['anonymousInfo'],true);
                break;
            default:
                $arr = array();
        }
        if($this->useCheck) {
            if(isset($arr['authTime']) && isset($arr['authToken'])) {
                $time = $arr['authTime'];
                if($time - time() <= $this->time) {
                    $token = strtolower($arr['authToken']);
                    if($token == md5($this->key.':'.$time)) {
                        unset($arr['authTime'],$arr['authToken']);
                    }else{
                        $arr = array();
                    }
                }else{
                    $arr = array();
                }
            }else{
                $arr = array();
            }
        }
        if($arr) {
            $tempArray = $arr;
            $arr = array();
            foreach ($tempArray as $key=>$value) {
                if(preg_match('/^[A-Z]+$/', substr($key,0,1))) $key = strtolower($key);
                $arr[$key] = $value;
            }
        }
        return $arr;
    }
}

class get_CoolQ extends core_CoolQ
{
    function __construct($add, $useCheck = false, $key = '', $time = 30, $format = 'JSON')
    {
        parent::__construct($add, $useCheck, $key, $time, $format);
    }

    function __destruct()
    {
        parent::__destruct();
    }

    /**
     * 取匿名成员信息
     * @param string $source 匿名成员的标识
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该匿名成员的信息
     */
    public function getAnonymousInfo($source)
    {
        return $this->getSource('getAnonymousInfo',$source);
    }

    /**
     * 获取AuthCode
     * @return int AuthCode，失败时返回负值
     */
    public function getAuthCode()
    {
        $arr = $this->getNoParamReturn('getAuthCode');
        return (!$arr['status']) ? $arr['result'] : $arr['status'];
    }

    /**
     * 取指定群中被禁言用户列表
     * @auth 20
     * @param number $groupID 目标群
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群中被禁言的用户列表
     */
    public function getBanList($groupID)
    {
        $arr = $this->newArray('getBanList',$groupID);
        return $this->sendData($arr);
    }

    /**
     * 取解禁剩余时间
     * @auth 20
     * @param number $groupID 目标群
     * @return int 禁言剩余时间，单位：秒，0为未禁言，获取失败时为负值
     */
    public function getBanStatus($groupID)
    {
        $arr = $this->newArray('getBanStatus',$groupID);
        $arr = $this->sendData($arr);
        return (!$arr['status']) ? $arr['result'] : $arr['status'];
    }

    /**
     * 取Cookies
     * @auth 20
     * @return string Cookies
     */
    public function getCookies()
    {
        $arr = $this->getNoParamReturn('getCookies');
        return (!$arr['status']) ? $arr['result'] : null;
    }

    /**
     * 取CsrfToken，即QQ网页用到的 bkn/g_tk等
     * @auth 20
     * @return int CsrfToken
     */
    public function getCsrfToken()
    {
        $arr = $this->getNoParamReturn('getCsrfToken');
        return (!$arr['status']) ? $arr['result'] : null;
    }

    /**
     * 取群文件信息
     * @param string $source 文件标识
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该文件的文件属性
     */
    public function getFileInfo($source)
    {
        return $this->getSource('getFileInfo',$source);
    }

    /**
     * 取字体信息
     * @param int $id 字体代码
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该字体信息
     */
    public function getFontInfo($id)
    {
        $arr = array('fun'=>'getFontInfo','id'=>$id);
        return $this->sendData($arr);
    }

    /**
     * 取好友列表
     * @auth 20
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：当前机器人所加的好友信息列表
     */
    public function getFriendList()
    {
        return $this->getNoParamReturn('getFriendList');
    }

    /**
     * 取群详细信息
     * @auth 20
     * @param number $groupID 目标群
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的详细信息
     */
    public function getGroupInfo($groupID)
    {
        $arr = $this->newArray('getGroupInfo',$groupID);
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
        $arr = $this->newArray('getGroupTopNote',$groupID);
        return $this->sendData($arr);
    }

    /**
     * 取头像链接
     * @auth 20
     * @param number $qq 目标QQ
     * @param int $size 头像尺寸，默认 100
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该QQ的头像链接
     */
    public function getHeadimgLink($qq,$size=100)
    {
        $arr = $this->newArray('getHeadimgLink',$qq);
        $arr['size'] = $size;
        return $this->sendData($arr);
    }

    /**
     * 获取图片信息
     * @param string $path 图片文件名，不带路径，并且必须是酷Q收到的图片
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该图片信息
     */
    public function getImageInfo($path)
    {
        return $this->getSource('getImageInfo',$path);
    }

    /**
     * 取群作业列表
     * @auth 20
     * @param number $groupID 目标群
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的作业列表(不存在未指定给机器人查看的作业)
     */
    public function getGroupHomeworkList($groupID)
    {
        $arr = $this->newArray('getGroupHomeworkList',$groupID);
        return $this->sendData($arr);
    }

    /**
     * 取群链接列表
     * @auth 20
     * @param number $groupID 目标群
     * @param int $number 数量，默认 10
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：在该群中发过的链接列表
     */
    public function getGroupLinkList($groupID,$number=10)
    {
        $arr = $this->newArray('getGroupLinkList',$groupID);
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
        return $this->getNoParamReturn('getGroupList');
    }

    /**
     * 取群成员信息
     * @auth 130
     * @param number $group 目标所在群
     * @param number $qq 目标QQ
     * @param bool $useCache 不使用缓存，True/使用 False/不使用，默认为 False
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群指定群成员的个人信息
     */
    public function getGroupMemberInfo($group, $qq, $useCache=true)
    {
        $arr = $this->newArray('getGroupMemberInfo',$group,$qq);
        $arr['cache'] = $useCache ? 1 : 0;
        return $this->sendData($arr);
    }

    /**
     * 获取群成员列表
     * @auth 160
     * @param number $groupID 目标群
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的群成员列表
     */
    public function getGroupMemberList($groupID)
    {
        $arr = $this->newArray('getGroupMemberList',$groupID);
        return $this->sendData($arr);
    }

    /**
     * 取群公告列表
     * @auth 20
     * @param number $groupID 目标群
     * @param int $number 公告数量，默认 10
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该群的公告列表
     */
    public function getGroupNoteList($groupID,$number=10)
    {
        $arr = $this->newArray('getGroupNoteList',$groupID);
        $arr['number'] = $number;
        return $this->sendData($arr);
    }

    /**
     * 取用户等级信息
     * @param int $qq 可空，空时取机器人等级信息
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：所提供的QQ的等级信息
     */
    public function getLevelInfo($qq=0)
    {
        $arr = $this->newArray('getLevelInfo','',$qq);
        return $this->sendData($arr);
    }

    /**
     * 取登录昵称
     * @return string 当前登录QQ的昵称
     */
    public function getLoginNick()
    {
        $arr = $this->getNoParamReturn('getLoginNick');
        return (!$arr['status']) ? $arr['result'] : null;
    }

    /**
     * 取登录QQ
     * @return int 登录QQ
     */
    public function getLoginQQ()
    {
        $arr = $this->getNoParamReturn('getLoginQQ');
        return (!$arr['status']) ? $arr['result'] : null;
    }

    /**
     * 批量取群头像
     * @auth 20
     * @param string $groupList 群列表，每个群用 - 分开，可空，参数值为空时，取所有群的头像
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：所提供的群号的头像链接列表
     */
    public function getMoreGroupHeadimg($groupList='')
    {
        $array = array('fun'=>'getMoreGroupHeadimg', 'groupList'=>$groupList);
        return $this->sendData($array);
    }

    /**
     * 批量取QQ头像
     * @auth 20
     * @param string $qqList QQ列表，每个QQ用 _ 分开
     * @param int $size 头像尺寸，默认100
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：所提供的QQ的头像链接列表
     */
    public function getMoreQQHeadimg($qqList, $size=100)
    {
        $array = array('fun'=>'getMoreQQHeadimg', 'qqList'=>$qqList, 'size'=>$size);
        return $this->sendData($array);
    }

    /**
     * 批量取QQ昵称
     * @auth 20
     * @param string $qqList QQ列表，每个QQ用 - 分开
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：所提供的QQ的昵称列表
     */
    public function getMoreQQName($qqList)
    {
        $arr = array('fun'=>'getMoreQQName', 'qqList'=>$qqList);
        return $this->sendData($arr);
    }

    /**
     * 接收消息中的语音(record)
     * @auth 30
     * @param string $fileName 文件名，收到消息中的语音文件名(file)
     * @param string $format 转码成何种音频文件，目前支持 mp3,amr,wma,m4a,spx,ogg,wav,flac，默认 mp3
     * @return string 成功时，数组中成员Status的值为0，并在成员Result中返回：解析该文件后，保存在 \data\record\ 目录下的语音文件名
     */
    public function getRecord($fileName, $format='mp3')
    {
        $array = array(
            'fun'=>'getRecord',
            'source'=>$fileName,
            'format'=>$format
        );
        $arr = $this->sendData($array);
        return (!$arr['status']) ? $arr ['result'] : null;
    }

    /**
     * 获取消息中的语音文件(record)
     * 本函数可以获取到完整文件
     * @auth 30
     * @param string $fileName 文件名，收到消息中的语音文件名(file)
     * @param string $format 指定格式，应用所需的语音文件格式，目前支持 mp3,amr,wma,m4a,spx,ogg,wav,flac
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该语音文件内容(BASE64编码)
     */
    public function getRecordFile($fileName, $format='mp3')
    {
        $array = array(
            'fun'=>'getRecordFile',
            'source'=>$fileName,
            'format'=>$format
        );
        return $this->sendData($array);
    }

    /**
     * 取软件状态
     * 像服务端发送一条消息，确认是否奔溃
     * @param int $time 最长等待时间，单位/秒，默认为3
     * @return bool 运行正常返回 True，奔溃情况下返回 False
     */
    public function getRunStatus($time=3)
    {
        $arr = $this->sendData(array('fun'=>'checkRun'),$time);
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
        $arr = $this->newArray('getShareList',$groupID);
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
        $arr = $this->newArray('getSignList',$groupID);
        return $this->sendData($arr);
    }

    /**
     * 取陌生人信息
     * @auth 131
     * @param number $qq 目标QQ
     * @param bool $useCache 不使用缓存，True/使用 False/不使用，默认为 False
     * @return array 成功时，数组中成员Status的值为0，并在成员Result中返回：该QQ的部分个人信息
     */
    public function getStrangerInfo($qq, $useCache=true)
    {
        $arr = $this->newArray('getStrangerInfo','',$qq);
        $arr['cache'] = $useCache ? 1 : 0;
        return $this->sendData($arr);
    }


}

class send_CoolQ extends get_CoolQ
{
    function __construct($add, $useCheck = false, $key = '', $time = 30, $format = 'JSON')
    {
        parent::__construct($add, $useCheck, $key, $time, $format);
    }

    function __destruct()
    {
        parent::__destruct();
    }

    /**
     * 发送讨论组信息
     * @auth 103
     * @param number $discuss 目标讨论组
     * @param string $msg 消息内容
     * @return int 状态码
     */
    public function sendDiscussMsg($discuss, $msg)
    {
        return $this->sendMsg('sendDiscussMsg',$discuss,'',$msg);
    }

    /**
     * 发送群消息
     * @auth 101
     * @param number $group 目标群
     * @param string $msg 消息内容
     * @return int 状态码
     */
    public function sendGroupMsg($group, $msg)
    {
        return $this->sendMsg('sendGroupMsg',$group,'',$msg);
    }

    /**
     * 发送手机赞
     * @auth 110
     * @param number $qq 目标QQ
     * @param int $count 赞的次数，最多10次，默认为1次
     * @return int 状态码
     */
    public function sendLike($qq, $count=1) //发送赞
    {
        $arr = $this->newArray('sendLike','',$qq);
        $arr['number'] = $count;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 发送私聊信息
     * @auth 106
     * @param number $qq 目标QQ
     * @param string $msg 消息内容
     * @return int 状态码
     */
    public function sendPrivateMsg($qq, $msg)
    {
        return $this->sendMsg('sendPrivateMsg','',$qq,$msg);
    }

}

class set_CoolQ extends send_CoolQ
{
    function __construct($add, $useCheck = false, $key = '', $time = 30, $format = 'JSON')
    {
        parent::__construct($add, $useCheck, $key, $time, $format);
    }

    function __destruct()
    {
        parent::__destruct();
    }

    /**
     * 置讨论组退出
     * @auth 140
     * @param number $discuss 目标讨论组号
     * @return int 状态码
     */
    public function setDiscussLeave($discuss)
    {
        $arr = $this->newArray('setDiscussLeave',$discuss);
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
    public function setFriendAddRequest($responseFlag, $subType, $name='')
    {
        $arr = array(
            'fun'=>'setFriendAddRequest',
            'responseFlag'=>$responseFlag,
            'subType'=>$subType,
            'name'=>$name
        );
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
    public function setGroupAddRequest($responseFlag, $subType, $type, $msg='')
    {
        $arr = array(
            'fun'=>'setGroupAddRequest',
            'responseFlag'=>$responseFlag,
            'subType'=>$subType,
            'type'=>$type,
            'msg'=>$msg
        );
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
    public function setGroupAdmin($group, $qq, $become=false)
    {
        $arr = $this->newArray('setGroupAdmin',$group,$qq);
        $arr['become'] = $become ? 1 : 0;
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
    public function setGroupAnonymous($group, $open=false)
    {
        $arr = $this->newArray('setGroupAnonymous',$group);
        $arr['open'] = $open ? 1 : 0;
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
        $arr = $this->newArray('setGroupAnonymousBan',$group);
        $arr['anonymous'] = $anonymous;
        $arr['time'] = $time;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置群成员禁言
     * @auth 121
     * @param number $group 目标所在群
     * @param number $qq 目标QQ
     * @param int $time 禁言的时间，单位为秒，可空。如果要解禁，这里填写 0；不得超过 2592000 (一个月)
     * @return int 状态码
     */
    public function setGroupBan($group, $qq, $time=0)
    {
        $arr = $this->newArray('setGroupBan',$group,$qq);
        $arr['time'] = $time;
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
    public function setGroupCard($group, $qq, $card='')
    {
        $arr = $this->newArray('setGroupCard',$group,$qq);
        $arr['card'] = $card;
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
    public function setGroupLeave($group, $disband=false)
    {
        $arr = $this->newArray('setGroupLeave',$group);
        $arr['disband'] = $disband ? 1 : 0;
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
    public function setGroupKick($group, $qq, $refuseJoin=false)
    {
        $arr = $this->newArray('setGroupKick',$group,$qq);
        $arr['refuseJoin'] = $refuseJoin ? 1 : 0;
        $arr = $this->sendData($arr);
        return $arr['status'];
    }

    /**
     * 置群签到
     * @auth 20
     * @param int $group 群号，可空，空时签到所有群
     * @return array 成功时，数组中成员Status的值为 0，并在成员Result中返回：本次签到成功的群数量
     */
    public function setGroupSign($group=0)
    {
        $arr = $this->newArray('setGroupSign',$group);
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
    public function setGroupSpecialTitle($group, $qq, $tip='', $time=-1)
    {
        $arr = $this->newArray('setGroupSpecialTitle',$group,$qq);
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
    public function setGroupWholeBan($group, $open=false)
    {
        $arr = $this->newArray('setGroupWholeBan',$group);
        $arr['open'] = $open ? 1 : 0;
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
        return $this->getNoParamReturn('setSign');
    }

    /**
     * 设置悬浮窗信息
     * @param string $data 数据内容
     * @param string $unit 数据单位
     * @param int $color 颜色，1/绿 2/橙 3/红 4/深红 5/黑 6/灰
     * @return string|int 悬浮窗文本，无用
     */
    public function setStatus($data, $unit, $color)
    {
        $array = array(
            'fun'=>'setStatus',
            'data'=>$data,
            'unit'=>$unit,
            'color'=>$color
        );
        $arr = $this->sendData($array);
        return (!$arr['status']) ? $array['result'] : $arr['status'];
    }


}

class CoolQ extends set_CoolQ
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
     * CoolQ constructor.
     * @param string $add 主机信息
     * @param bool $useCheck 使用数据校验
     * @param string $key 数据校验所需 Key
     * @param int $time 数据有效时间
     * @param string $format 数据格式
     */
    function __construct($add, $useCheck = false, $key = '', $time = 30, $format = 'JSON')
    {
        parent::__construct($add, $useCheck, $key, $time, $format);
    }

    function __destruct()
    {
        parent::__destruct();
    }

    /**
     * 添加日志
     * @param int $level 优先级，请使用 log_ 开头的常量，如 $CQ->log_debug
     * @param string $type 日志类型
     * @param string $text 日志内容
     * @return array 成功时，数组中成员Status的值为0，Result为日志ID
     */
    public function addLog($level=0, $type='', $text='')
    {
        $arr = array(
            'fun'=>'addLog',
            'level'=>$level,
            'type'=>$type,
            'text'=>$text
        );
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
    public function downFile($url, $name='', $type=1, $md5='')
    {
        $arr = array(
            'fun'=>'downFile',
            'url'=>$url,
            'name'=>$name,
            'type'=>$type,
            'md5'=>$md5
        );
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
        return $this->getNoParamReturn('rebootService');
    }

}
