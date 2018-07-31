<?php
/**
 * 入口文件
 */

define('SITE_PATH', dirname(__FILE__).'/');
include SITE_PATH.'CoolQ.class.php';
include SITE_PATH.'CoolQ.config.php';
include SITE_PATH.'CoolQ.demo.php';
include SITE_PATH.'CoolQ.event.php';

//如果后续业务逻辑仍需要调用API，请注释掉此语句。
unset($CQ); //释放资源