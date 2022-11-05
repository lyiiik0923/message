<?php
header("Content-Type: text/html; charset=utf-8");

error_reporting(0);


include "libs/cfg_mail.php"; 
include "libs/lib_mail.php"; 


$demo = $_GET[demo];




if($demo!=""){
  if(!in_array($demo,array("send","code","help"))){error("参数错误!");}
  switch($demo){
	case "code":
		exit(highlight_file("demo.php",TRUE));
	break;
	case "help":
		exit($help);
	break;

  }
}

function getval($key){
	if(!isset($_POST[$key])||$_POST[$key]==NULL||$_POST[$key]==''){
		return ($_GET[$key] !=''&& isset($_GET[$key])) ? trim($_GET[$key]) : NULL;
	}else{
		return ($_POST[$key] !=''&& isset($_POST[$key])) ? trim($_POST[$key]) : NULL;
	}
}

function error($msg){
	exit("<b>HEQEE INFO:</b> ".$msg);
}
function gbkToUtf8 ($value) { 
	return iconv("gbk", "UTF-8", $value); 
}

$send=array();
$send['name'] = gbkToUtf8(getval('name') != NULL ? getval('name') : getval('n'));
$send['email'] = gbkToUtf8(getval('email') != NULL ? getval('email') : getval('e'));
$send['website']   = gbkToUtf8(getval('website') != NULL ? getval('website') : getval('w'));
$send['message']  = gbkToUtf8(getval('message') != NULL ? getval('message') : getval('m'));


switch($send){
	case $send['name']==NULL:
		error('请输入您的姓名.');
	break;
	case $send['email']==NULL:
		error('请输入你的邮箱地址.');
	break;
	case $send['message']==NULL:
		error('请输入留言内容.');
	break;

}

$message = "姓名：".$send['name']."<br>";
$message.= "邮箱：".$send['email']."<br>";
$message.= "网站：".($send['website'] == '' ? '尚未提供' : $send['website'])."<br>";
$message.= "内容：".$send['message']."<br>";
$message.= "本服务由<a href=http:/www.heqee.com target=_blank>HeQee</a>提供技术支持";


//print_r($cfg);
return lib_mail::send($cfg['to_email'],$send['name'],$cfg['from_title'],$message,'html');

?>