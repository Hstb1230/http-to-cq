<?php

	/*
	此处设置主机相关信息
	如果是 本地ip(127.0.0.1) 的话不建议设置成 localhost
	*/
	$ip = '127.0.0.1';
	$port = '19730';


function ErrStop($text) {
	die("Error:".$text);
}

class WebsocketClient {
	
	private $_Socket = null;
	
	
	public function __construct($host,$port) {
		$this->_connect($host,$port);
	}
 
	public function __destruct() {
		fclose($this->_Socket);
	}
	
	public function sendData($data) {//send actual data:
	    fwrite($this->_Socket, $this->encode($data)) or ErrStop(iconv("GB2312", "UTF-8//IGNORE", $errstr).'('.$errno.')');
		$wsData = fread($this->_Socket,8192);
		$retData = trim($wsData,chr(0).chr(255));
		return $retData;
	}
	
	private function encode($data) {
		$data = is_array( $data ) || is_object( $data ) ? json_encode( $data ) : (string) $data;
		$len = strlen( $data );
		$mask=array();
		for ($j=0;$j<4;$j++) {
			$mask[]=mt_rand(1,255);
		}
		$head[0] = 129;
		if ( $len <= 125 ) {
			$head[1] = $len;
		} elseif ( $len <= 65535 ) {
			$split = str_split( sprintf('%016b', $len ), 8 );
			$head[1] = 126;
			$head[2] = bindec( $split[0] );
			$head[3] = bindec( $split[1] );
		} else {
			$split = str_split( sprintf('%064b', $len ), 8 );
			$head[1] = 127;
			for ( $i = 0; $i < 8; $i++ ) {
				$head[$i+2] = bindec( $split[$i] );
			}
			if ( $head[2] > 127 ) {
				return false;
			}
		}
		$head[1]+=128;
		$head=array_merge($head,$mask);
		foreach( $head as $k => $v ) {
			$head[$k] = chr( $v );
		}
		$mask_data='';
		for ($j=0;$j<$len;$j++) {
			$mask_data.=chr(ord($data[$j]) ^ $mask[$j % 4]);
		}
		return implode('', $head ).$mask_data;
	}

	private function _connect($host, $port) {
		$key1 = $this->_generateRandomString(32);
		$key2 = $this->_generateRandomString(32);
		$key3 = $this->_generateRandomString(8, false, true);		
        $header = "GET ws://".$host.":".$port."/ HTTP/1.1\r\n";
        $header.= "Host: ".$host.":".$port."\r\n";
        $header.= "Connection: Upgrade\r\n";
        $header.= "Upgrade: websocket\r\n";
        $header.= "Sec-WebSocket-Version: 13\r\n";
        $header.= "Sec-WebSocket-Key: " . $key1 . "\r\n";
        $header.= "\r\n";
		$this->_Socket = fsockopen($host, $port, $errno, $errstr, 2);
		fwrite($this->_Socket, $header) or ErrStop(iconv("GB2312", "UTF-8//IGNORE", $errstr).'('.$errno.')');
		$response = fread($this->_Socket, 8192);
		return true;
	}
   
	private function _generateRandomString($length = 10, $addSpaces = true, $addNumbers = true) {  
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$useChars = array();
		// select some random chars:
		for($i = 0; $i < $length; $i++)	{
			$useChars[] = $characters[mt_rand(0, strlen($characters)-1)];
		}
		// add spaces and numbers:
		if($addSpaces === true)	{
			array_push($useChars, ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');
		}
		if($addNumbers === true) {
			array_push($useChars, rand(0,9), rand(0,9), rand(0,9));
		}
		shuffle($useChars);
		$randomString = trim(implode('', $useChars));
		$randomString = substr($randomString, 0, $length);
		return $randomString;
	}
}

	$WebSocketClient = new WebsocketClient($ip,$port);//建立连接,失败则无法运行本脚本
	
	function SendData($text) {
		global $WebSocketClient; 
		$Get = $WebSocketClient->sendData($text);
		return $Get;
	}
	
	function EndSocket() {
		global $WebSocketClient; 
		unset($WebSocketClient);//释放连接
	}

class CoolQ {

	
	public function __destruct() {
		EndSocket();
	}
	
	//一般情况下返回状态码(0为成功),详细说明请见 http://d.cqp.me/Pro/%E5%BC%80%E5%8F%91/Error
	
	public function sendPrivateMsg($QQ,$Msg) {//发送私聊信息
		$array = array(
			'Fun'=>'sendPrivateMsg',
			'QQ'=>$QQ,
			'Msg'=>$Msg
		);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function sendGroupMsg($Group,$Msg) {//发送群信息
		$array = array(
		    'Fun'=>'sendGroupMsg',
			'Group'=>$Group,
			'Msg'=>$Msg
		);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function sendDiscussMsg($Discuss,$Msg) {//发送讨论组信息
		$array = array(
		    'Fun'=>'sendDiscussMsg',
			'Group'=>$Discuss,
			'Msg'=>$Msg
		);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function sendLike($QQ,$Count=1) {//发送赞
		$array = array(
		    'Fun'=>'sendLike',
			'QQ'=>$QQ,
			'Count'=>$Count//赞的次数,最多为10
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function getRecord($FileName,$Format) {//接收语音
		$array = array(
		    'Fun'=>'getRecord',
			'File'=>$FileName,//语音文件名,不带路径
			'Format'=>$Format//所需的语音文件格式，目前支持 mp3,amr,wma,m4a,spx,ogg,wav,flac
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Result'};//返回转换后的文件名
	}
	
	public function getLoginQQ() {//取登录QQ
		$array = array('Fun'=>'getLoginQQ');
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Result'};
	}
	
	public function setGroupLeave($Group,$Dissolution=false) {//置群退出
	    $Temp = $Dissolution?1:0;//是否解散
		$array = array(
		    'Fun'=>'setGroupLeave',
			'Group'=>$Group,
			'Dissolution'=>$Temp
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function getCookies() {//取Cookies
		$array = array('Fun'=>'getCookies');
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Result'};
	}
	
	public function getLoginNick() {//取登录昵称
		$array = array('Fun'=>'getLoginNick');
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Result'};
	}
	
	public function getCsrfToken() {//取CsrfToken
		$array = array('Fun'=>'getCsrfToken');
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Result'};
	}
	
	public function getGroupMemberInfo($Group,$QQ,$UseCache=true) {//取群成员信息
		$Temp = $UseCache?1:0;//真为使用缓存
		$array = array(
		    'Fun'=>'getGroupMemberInfo',
			'Group'=>$Group,
			'QQ'=>$QQ,
			'Cache'=>$Temp
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		return $Get;//返回带有数据的Json文本
	}
	
	public function getStrangerInfo($QQ,$UseCache=true) {//取陌生人信息
		$Temp = $UseCache?1:0;//真为使用缓存
		$array = array(
		    'Fun'=>'getStrangerInfo',
			'QQ'=>$QQ,
			'Cache'=>$Temp
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		return $Get;//返回带有数据的Json文本
	}
	
	public function GetFontInfo($ID) {//其他_字体转换
		$array = array(
		    'Fun'=>'GetFontInfo',
			'ID'=>$ID,
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		return $Get;//返回带有数据的Json文本
	}
	
	public function GetAnonymousInfo($source) {//其他_转换_文本到匿名
		$array = array(
		    'Fun'=>'GetAnonymousInfo',
			'source'=>$source,
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		return $Get;//返回带有数据的Json文本
	}
	
	public function GetFileInfo($source) {//其他_转换_文本到群文件
		$array = array(
		    'Fun'=>'GetFileInfo',
			'source'=>$source,
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		return $Get;//返回带有数据的Json文本
	}
	
	public function SetStatus($Data,$Unit,$Color) {//其他_转换_悬浮窗到文本,实际上就是设置悬浮窗
		$array = array(
		    'Fun'=>'SetStatus',
			'Data'=>$Data,//数据
			'Unit'=>$Unit,//数据单位
			'Color'=>$Color//显示的颜色 1/绿 2/橙 3/红 4/深红 5/黑 6/灰
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Result'};//返回转换的文本,无卵用
	}
	
	public function setGroupKick($Group,$QQ,$RefuseJoin=false) {//置成员移除
	    $Temp = $RefuseJoin?1:0;//真为不再接受加群申请
		$array = array(
		    'Fun'=>'setGroupKick',
			'Group'=>$Group,
			'QQ'=>$QQ,
			'RefuseJoin'=>$Temp
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function setGroupBan($Group,$QQ,$Time=0) {//置成员禁言
		$array = array(
		    'Fun'=>'setGroupBan',
			'Group'=>$Group,
			'QQ'=>$QQ,
			'Time'=>$Time//0为解除禁言
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function setGroupAdmin($Group,$QQ,$Become=false) {//置群管理员
	    $Temp = $Become?1:0;//真为设置管理员,假为取消管理员
		$array = array(
		    'Fun'=>'setGroupAdmin',
			'Group'=>$Group,
			'QQ'=>$QQ,
			'Become'=>$Temp
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function setGroupWholeBan($Group,$IsGag=false) {//置全群禁言
	    $Temp = $IsGag?1:0;//真为开启,假为关闭
		$array = array(
		    'Fun'=>'setGroupWholeBan',
			'Group'=>$Group,
			'IsGag'=>$Temp
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	
	public function setGroupAnonymous($Group,$Open=false) {//置群匿名设置
	    $Temp = $Open?1:0;//真为开启匿名,假为关闭
		$array = array(
		    'Fun'=>'setGroupAnonymous',
			'Group'=>$Group,
			'Open'=>$Temp
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function setGroupCard($Group,$QQ,$Card=null) {//置群成员名片
		$array = array(
		    'Fun'=>'setGroupCard',
			'Group'=>$Group,
			'QQ'=>$QQ,
			'Card'=>$Card//为空时清空群名片
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function setDiscussLeave($Discuss) {//置讨论组退出
		$array = array(
		    'Fun'=>'setDiscussLeave',
			'Group'=>$Discuss
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function setGroupAddRequest($responseFlag,$subtype,$type,$Msg=null) {//置群添加请求
		$array = array(
		    'Fun'=>'setGroupAddRequest',
			'responseFlag'=>$responseFlag,
			'subtype'=>$subtype,//  1/群添加,2/群邀请
			'type'=>$type,//  1/通过,2/拒绝
			'Msg'=>$Msg//拒绝时的理由
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function setGroupAnonymousBan($Group,$Anonymous,$Time=0) {//置匿名群员禁言
		$array = array(
		    'Fun'=>'setGroupAnonymousBan',
			'Group'=>$Group,
			'Anonymous'=>$Anonymous,
			'Time'=>$Time
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function setFriendAddRequest($responseFlag,$Type,$Name=null){//置好友添加请求
		$array = array(
		    'Fun'=>'setFriendAddRequest',
			'responseFlag'=>$responseFlag,
			'Type'=>$Type,//  1/通过,2/拒绝
			'Name'=>$Name//备注
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function setGroupSpecialTitle($Group,$QQ,$Tip=null,$Time=0) {//置群成员专属头衔
		$array = array(
		    'Fun'=>'setGroupSpecialTitle',
			'Group'=>$Group,
			'QQ'=>$QQ,
			'Tip'=>$Tip,//头衔名称
			'Time'=>$Time//过期时间
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Status'};
	}
	
	public function downFile($URL,$Name=null,$Type=1,$MD5=null) {//下载文件
		$array = array(
		    'Fun'=>'downFile',
			'URL'=>$URL,//文件的URL地址
			'Name'=>$Name,//完整文件名,如果未传入则使用md5值
			'Type'=>$Type,//文件类型,1为图片,2为音乐文件
			'MD5'=>$MD5//用于校验文件完整性
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		$array = json_decode($Get);
		return $array->{'Result'};//返回文件的相对路径
	}
	
	public function getImageInfo($FileName) {//获取图片信息
		$array = array(
		    'Fun'=>'getImageInfo',
			'File'=>$FileName//图片名,不带路径,并且必须是酷Q收到的图片
			);
		$Json = json_encode($array);
		$Get = SendData($Json);
		return $Get;//返回带有数据的Json文本
	}
}

$CQ = new CoolQ();