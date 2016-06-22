<?php

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once('includes/cls_json.php');



if (!isset($_REQUEST['step']))
{
    $_REQUEST['step'] = "";
}

$result = array('error' => 0, 'message' => '');
$json = new JSON;

$mobile = trim($_POST['mobile']);

$count = $db->getOne("SELECT COUNT(id) FROM " . $ecs->table('verifycode') ." WHERE getip='" . real_ip() . "' AND dateline>'" . gmtime() ."'-120");

if ($_REQUEST['step'] == 'getverifycode')
{
    require(dirname(__FILE__) . '/send.php');

	/* 是否开启手机短信验证 */
	if($_CFG['sms_register'] == '0') {
		$result['error'] = 1;
		$result['message'] = '客户注册发送手机验证码未开启';
        die($json->encode($result));
	}
	
	/* 提交的手机号是否已经注册帐号 */
    $sql = "SELECT COUNT(user_id) FROM " . $ecs->table('users') ." WHERE mobile_phone = '$mobile'";

    if ($db->getOne($sql) > 0)
    {
        $result['error'] = 3;
		$result['message'] = '手机号已经被注册，请重新输入！';
        die($json->encode($result));
    }


	/* 获取验证码请求是否获取过 */
	$sql = "SELECT COUNT(id) FROM " . $ecs->table('verifycode') ." WHERE status=1 AND getip='" . real_ip() . "' AND dateline>'" . gmtime() ."'-"."60";

    if ($db->getOne($sql) > 0)
    {
        $result['error'] = 4;
		$result['message'] = '每个ip每120秒只能获取一次验证码';
        die($json->encode($result));
    }
	$shuzi = "0123456789";
	$verifycode = mc_random(6,$shuzi);

    $smarty->assign('user_mobile',	$mobile);
    $smarty->assign('verify_code',  $verifycode);

    $content = '您的验证码为'.$verifycode.'【68ecshop】';
	/* 发送注册手机短信验证 */
	$ret = sendSMS($mobile, $content);
	
    $db->query("delete from ".$ecs->table('verifycode')." where mobile='$mobile'");
	
		//插入获取验证码数据记录
		$sql = "INSERT INTO " . $ecs->table('verifycode') . "(mobile, getip, verifycode, dateline) VALUES ('" . $mobile . "', '" . real_ip() . "', '$verifycode', '" . gmtime() ."')";
		$db->query($sql);

		$result['error'] = 0;
		$result['message'] = '发送手机验证码成功';
		die($json->encode($result));
}

if ($_REQUEST['step'] == 'getverifycode2')
{
    require(dirname(__FILE__) . '/send.php');

	/* 是否开启手机短信验证 */
	if($_CFG['sms_register'] == '0') {
		$result['error'] = 1;
		$result['message'] = '客户注册发送手机验证码未开启';
        die($json->encode($result));
	}
	
	/* 获取验证码请求是否获取过 */
	$sql = "SELECT COUNT(id) FROM " . $ecs->table('verifycode') ." WHERE status=1 AND getip='" . real_ip() . "' AND dateline>'" . gmtime() ."'-"."60";

    if ($db->getOne($sql) > 0)
    {
        $result['error'] = 4;
		$result['message'] = '每个ip每120秒只能获取一次验证码';
        die($json->encode($result));
    }
	$shuzi = "0123456789";
	$verifycode = mc_random(6,$shuzi);

    $smarty->assign('user_mobile',	$mobile);
    $smarty->assign('verify_code',  $verifycode);

    $content = '您的验证码为'.$verifycode.'【68ecshop】';
	/* 发送注册手机短信验证 */
	$ret = sendSMS($mobile, $content);
	
    $db->query("delete from ".$ecs->table('verifycode')." where mobile='$mobile'");
	
		//插入获取验证码数据记录
		$sql = "INSERT INTO " . $ecs->table('verifycode') . "(mobile, getip, verifycode, dateline) VALUES ('" . $mobile . "', '" . real_ip() . "', '$verifycode', '" . gmtime() ."')";
		$db->query($sql);

		$result['error'] = 0;
		$result['message'] = '发送手机验证码成功';
		die($json->encode($result));
}


function mc_random($length,$char_str = 'abcdefghijklmnopqrstuvwxyz0123456789'){
	$hash='';
	$chars = $char_str;
	$max=strlen($chars);
	for($i=0;$i<$length;$i++){
		$hash .=substr($chars,(rand(0,1000)%$max),1); 
	}
	return $hash;
}

?>