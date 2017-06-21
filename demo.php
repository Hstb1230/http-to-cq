<?php

//下面是两种获取数据的方法

/* [1]使用"Json"数据格式提交

//Post提交
$input = file_get_contents("php://input"); //接收提交的所有POST数据
$input = urldecode($input);//对提交的POST数据解码

//Get提交
if(!$input and isset($_GET['msg'])) $input = urldecode($_GET['msg']);

if(!$input)  exit;

$Array = json_decode($input);//对数据进行Json解析
$Array->{'Msg'} = urldecode($Array->{'Msg'});//URL解码

*/

/* [2]使用"Key=Value"数据格式提交

$Array = !empty($_POST)?$_POST:$_GET;

if(empty($Array)) exit;

*/


/* 使用动态交互 
include './sdk.php';
//下面是发送消息例子
switch ($Array->{'Type'}) {
  case 1:
  $CQ->sendPrivateMsg($Array->{'QQ'},'FromHttpSocket:'.$Array->{'Msg'});
  break;
case 2:
  $CQ->sendGroupMsg($Array->{'Group'},'FromHttpSocket:'.$Array->{'Msg'});
  break;
case 4:
  $CQ->sendDiscussMsg($Array->{'Group'},'FromHttpSocket:'.$Array->{'Msg'});
  break;
default:
  exit('[]');
}
unset($CQ);//释放连接
*/

exit('[]');