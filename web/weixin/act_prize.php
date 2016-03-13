<?php
require(dirname(__FILE__) . '/api.class.php');
if(!$_SESSION['user_id']){
	//$_SESSION['user_id'] = 12;
	exit("need login");
}
$aid = intval($_GET['aid']);
$api = new weixinapi();
$arr = $api->doAward($aid);
echo json_encode($arr);