<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 */

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta charset="utf-8">
    <meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<style type="text/css">
#page{
	width: 98%;
	height: 10em;
	margin:1em auto;
	
	font-size:1em;
	line-height:1.5em;
}
#page2{
	width: 98%;
	height: 10em;
	margin:1em auto;
	;
	font-size:1em;
	line-height:1.5em;
}
</style>

        <title>支付宝即时到账交易接口</title>
		
	</head>
    <body>
	
<?php
//计算得出通知验证结果

$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();

if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$result = $_GET['result'];


	//判断该笔订单是否在商户网站中已经做过处理
		//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		//如果有做过处理，不执行商户的业务程序
		
	
	if($result=="success"){
	?>
	
<div id='page'>
	<div style="text-align:center;color:red;font-size:2em;font-weight: bold;">
	<br />
	<br />
	<br />
	祝贺您!您的订单支付已经成功!!!3秒后自动跳转动商城首页
	
	</div>
</div>

<?php
	}else{
	//支付失败
		
?>
<div id='page2'>
	<div style="text-align:center;font-weight: bold; font-size:2em;color:red;">
	<br />
	<br />
	<br />
	很抱歉,您的订单支付失败!3秒后自动跳转动商城首页
	</div>
</div>
<?php
	}
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
   
	?>
<div id='page2'>
	<div style="text-align:center;font-weight: bold;font-size:2em;"><span style="color:red;">支付失败</span><br />
	支付过程中出现验证错误,如果你的支付宝金额已被扣除,请联系开发商"
	</div>
</div>
<?php
}
?>
	<script type="text/javascript">
		window.setTimeout("window.location='http://ecsmart.68ecshop.com/mobile/'",3000); 
	</script>
    </body>
</html>