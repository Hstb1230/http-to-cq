<?php

include 'SDK.php';

$input = file_get_contents("php://input"); //接收提交的所有POST数据
$input = urldecode($input);//对提交的POST数据解码
$Array = json_decode($input);//对解码后的数据进行Json解析

$CQ->sendGroupMsg(553601318,"ThisMsgFromSocket:".urldecode($Array->{'Msg'}));

echo '{"data":{"Type":2,"Group":553601318,"Msg":"FromHttp:'.urldecode($Array->{'Msg'}).'"}}';

unset($CQ);//释放连接