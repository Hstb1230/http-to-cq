<?php
//Get提交
/*
$input = $_GET['msg'];
$Array = json_decode($input);

*/

//Post提交
$input = file_get_contents("php://input"); //接收提交的所有POST数据
$input = urldecode($input);//对提交的POST数据解码
$Array = json_decode($input);//对解码后的数据进行Json解析


$a = '{"data":{"Type":'.$Array->{'Type'}.',"Group":'.$Array->{'Group'}.',"Msg":"FromHttp:'.urldecode($Array->{'Msg'}).'"}}';

echo $a;


//使用WebSocket发送
include 'sdk.php';
if ($Array->{'Type'}==2) $CQ->sendGroupMsg($Array->{'Group'},"ThisMsgFromSocket:".urldecode($Array->{'Msg'}));
unset($CQ);//释放连接


//使用Socket推送

if (!extension_loaded('sockets')) {
	if (strtoupper(substr(PHP_OS, 3)) == "WIN") {
		dl('php_sockets.dll');
    } else {
		dl('sockets.so');
    }
}

    $server_ip = "127.0.0.1";//插件所在主机的IP地址
	$port = 19730;//插件监听的端口号
   
    $Key = '123';//插件设置的key
    $Secert = '456';//插件设置的Secert
   
    $hash = ;
    if ($Key) $hash =  "$Key:";
    $time = time();
    $hash .= $time; 
    if ($Secert) $hash .= ":$Secert";
    $hash = md5($hash);
    
	$JsonArray=json_decode($a);
    $return = array(
         "Time"=>$time,
        'Sign'=>$hash,
        'data'=>$JsonArray);
    //$JsonArray是要处理的数据(未转为Json的数据数组)
    $buf = json_encode($return);
    $sock = @socket_create(AF_INET, SOCK_DGRAM, 0);
    if (!@socket_sendto($sock, $buf, strlen($buf), 0, $server_ip, $port)) {
        //发送数据失败
        echo "send error\n";
        socket_close($sock);
        exit();
    }