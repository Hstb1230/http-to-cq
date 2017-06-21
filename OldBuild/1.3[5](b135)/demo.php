<?php

/* 获取数据,请注释其中一方代码
//Post提交
$input = file_get_contents("php://input"); //接收提交的所有POST数据
$input = urldecode($input);//对提交的POST数据解码
//Get提交
$input = $_GET['msg'];
$Json = json_decode($input);//对解码后的数据进行Json解析
*/



/* 使用WebSocket通信
include './sdk.php';
//下面是发送消息例子
switch ($Json['Type']) {
  case 1:
  $CQ->sendPrivateMsg($Json['QQ'],'FromWebSocket:'.$Json['Msg']);
  break;
case 2:
  $CQ->sendGroupMsg($Json['Group'],'FromWebSocket:'.$Json['Msg']);
  break;
case 4:
  $CQ->sendDiscussMsg($Json['Group'],'FromWebSocket:'.$Json['Msg']);
  break;
default:
  die('[]');
}
unset($CQ);//释放连接
*/



/*  使用Socket推送

if(!extension_loaded('sockets')){
    if (strtoupper(substr(PHP_OS, 3)) == "WIN") {
      dl('php_sockets.dll');
    } else {
      dl('sockets.so');
    }
  }

$server_ip = "127.0.0.1";//插件所在主机的IP地址
$port = 1900;//插件监听的端口号

$Key = '123';//插件设置的key
$Secert = '456';//插件设置的Secert

if ($Key) $hash =  "$Key:";
$time = time();
$hash .= $time; 
if ($Secert) $hash .= ":$Secert";
$hash = md5($hash);

$a = '{"Type":1,"Group":12345678,"Msg":"测试","Send":1}';//要处理的数据
$Json = json_decode($a);
$return = array(
  'Time'=>$time,
  'Sign'=>$hash,
  'data'=>$Json
);
$buf = json_encode($return);
$sock = @socket_create(AF_INET, SOCK_DGRAM, 0);
if (!@socket_sendto($sock, $buf, strlen($buf), 0, $server_ip, $port)) {
  //发送数据失败,通过http直接处理
  $return = array('data'=>$Json);
  echo json_encode($return);
  socket_close($sock);
  exit;
}
*/

