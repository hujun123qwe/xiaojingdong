<?php

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' . $GLOBALS ['_CFG'] ['lang'] . '/payment/weixin.php';

if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
	$i = isset ( $modules ) ? count ( $modules ) : 0;
	
	/* 代码 */
	$modules [$i] ['code'] = basename ( __FILE__, '.php' );
	
	/* 描述对应的语言项 */
	$modules [$i] ['desc'] = 'weixin_desc';
	
	/* 是否支持货到付款 */
	$modules [$i] ['is_cod'] = '0';
	
	/* 是否支持在线支付 */
	$modules [$i] ['is_online'] = '1';
	
	/* 作者 */
	$modules[$i]['author']  = '68ecshop';
	
	/* 网址 */
	$modules[$i]['website'] = 'http://www.68ecshop.com';
	
	/* 版本号 */
	$modules [$i] ['version'] = '1.0.0';
	
	/* 配置信息 */
	$modules [$i] ['config'] = array (
			array (
					'name' => 'appId',
					'type' => 'text',
					'value' => '' 
			),
			array (
					'name' => 'appSecret',
					'type' => 'text',
					'value' => '' 
			),
			array (
					'name' => 'partnerId',
					'type' => 'text',
					'value' => '' 
			),
			array (
					'name' => 'partnerKey',
					'type' => 'text',
					'value' => '' 
			) 
	// array('name' => 'notify_url', 'type' => 'text', 'value' => ''),
	// array('name' => 'is_instant', 'type' => 'select', 'value' => '0')
	// array('name' => 'alipay_pay_method', 'type' => 'select', 'value' => '')
		);
	
	return;
}

/**
 * 类
 */
class weixin
{

    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function weixin()
    {
    }

    function __construct()
    {
        $this->weixin();
    }

    /**
     * 生成支付代码
     * @param   array   $order      订单信息
     * @param   array   $payment    支付方式信息
     */
	function get_code($order, $payment)
	{
		$return_url = 'http://' . $_SERVER ['HTTP_HOST'].'/respond.php';
		define ( APPID, $payment ['appId'] ); // appid
		define ( APPSECRET, $payment ['appSecret'] ); // appSecret
		define ( MCHID, $payment ['partnerId'] );
		define ( KEY, $payment ['partnerKey'] ); // 通加密串
		define ( NOTIFY_URL, $return_url ); // 成功回调url

		include_once ("weixin/WxPayPubHelper.php");
		$selfUrl = 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['PHP_SELF'] . '?' . $_SERVER ['QUERY_STRING'];
		if (! strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MicroMessenger' )) {
			return $this->natpayHtml ( $order );
		}
		$jsApi = new JsApi_pub ();
		if($_SESSION['user_id']){
			$openid = $GLOBALS['db']->getOne("select fake_id from " . $GLOBALS['ecs']->table('weixin_user') . " where ecuid='{$_SESSION['user_id']}'");
		}
		$openid = $openid ? $openid : $_SESSION['wx_openid'];
		if(!$openid){
			if (! isset ( $_GET ['code'] )) {
				// 触发微信返回code码
				$url = $jsApi->createOauthUrlForCode ( $selfUrl );
				Header ( "Location: $url" );exit;
			} else {
				// 获取code码，以获取openid
				$code = $_GET ['code'];
				$jsApi->setCode ( $code );
				$openid = $jsApi->getOpenId ();
				$_SESSION['wx_openid'] = $openid;
			}
		}
		$unifiedOrder = new UnifiedOrder_pub ();
		// 设置统一支付接口参数
		$unifiedOrder->setParameter ( "openid", $openid );
		$unifiedOrder->setParameter ( "body", $order ['order_sn'] );
		$unifiedOrder->setParameter ( "out_trade_no", $order ['order_id'] ); // 商户订单号
		$unifiedOrder->setParameter ( "total_fee", $order ['order_amount'] * 100 ); // 总金额
		$unifiedOrder->setParameter ( "notify_url", NOTIFY_URL ); // 通知地址
		$unifiedOrder->setParameter ( "trade_type", "JSAPI" ); // 交易类型
		
		$prepay_id = $unifiedOrder->getPrepayId();
		$jsApi->setPrepayId($prepay_id);
		return $jsApi->getParameters();
	}
	
	/**
	 * 响应操作
	 */
	function respond() {
		include_once ("weixin/WxPayPubHelper.php");
		// 使用通用通知接口
		$notify = new Notify_pub ();
		// 存储微信的回调
		$xml = $GLOBALS ['HTTP_RAW_POST_DATA'];
		$notify->saveData ( $xml );
		$payment = get_payment ( 'weixin' );
		define ( KEY, $payment ['partnerKey'] ); // 通加密串
		if ($notify->checkSign () == TRUE) {
			if ($notify->data ["return_code"] == "FAIL") {
				$this->addLog ( $notify, 401 );
			} elseif ($notify->data ["result_code"] == "FAIL") {
				$this->addLog ( $notify, 402 );
			} else {
				$this->addLog ( $notify, 200 );
				$order_sn = intval ( $notify->data ['out_trade_no'] );
				$log_id = $GLOBALS ['db']->getOne ( "SELECT log_id FROM " . $GLOBALS ['ecs']->table ( 'pay_log' ) . "where order_id='{$order_sn}' and is_paid=0 order by log_id desc" );
				/* 检查支付的金额是否相符 */
				if (! check_money ( $log_id, $notify->data ['total_fee']/100 )) {
					$this->addLog ( $notify, 404 );
					return true;
				}
				order_paid ( $log_id, 2 );
				echo 'success';exit;
				//新接口无需发货
				/**
				include_once ("Wechat.php");
				$wechat = new Wechat ();
				$parameter = array (
						'appid' => $payment ['appId'],
						'openid' => $notify->data ['openid'],
						'transid' => $notify->data ['transaction_id'],
						'out_trade_no' => $order_sn,
						'deliver_timestamp' => time (),
						'deliver_status' => '1',
						'deliver_msg' => 'ok' 
				);
				$result = $wechat->delivernotify ( $payment, $parameter );
				*/
			}
		}else{
			$this->addLog ( $notify, 403 );
		}
		return true;
	}
	function addLog($other = array(), $type = 1) {
		$log ['ip'] = $_SERVER['REMOTE_ADDR'];
		$log ['time'] = date('Y-m-d H:i:s');
		$log ['get'] = $_REQUEST;
		$log ['other'] = $other;
		$log = serialize ( $log );
		return $GLOBALS ['db']->query ( "INSERT INTO " . $GLOBALS['ecs']->table('weixin_paylog') . " (`log`,`type`) VALUES ('$log','$type')" );
	}
	// 生成原生支付二维码
	function natpayHtml($order) {
		if (! strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MicroMessenger' )) {
			$unifiedOrder = new UnifiedOrder_pub ();
			// 设置统一支付接口参数
			$return_url = 'http://' . $_SERVER ['HTTP_HOST'].'/respond.php';
			$unifiedOrder->setParameter ( "body", $order ['order_sn'] );
			$unifiedOrder->setParameter ( "out_trade_no", $order ['order_id'] ); // 商户订单号
			$unifiedOrder->setParameter ( "total_fee", $order ['order_amount'] * 100 ); // 总金额
			$unifiedOrder->setParameter ( "notify_url", $return_url ); // 通知地址
			$unifiedOrder->setParameter ( "trade_type", "NATIVE" ); // 交易类型
			$unifiedOrderResult = $unifiedOrder->getResult();
			if ($unifiedOrderResult["return_code"] == "FAIL") {
				return "通信出错：".$unifiedOrderResult['return_msg']."<br>";
			}elseif($unifiedOrderResult["result_code"] == "FAIL"){
				$log_id = $GLOBALS ['db']->getOne ( "SELECT log_id FROM " . $GLOBALS ['ecs']->table ( 'pay_log' ) . "where order_id='{$order ['order_id']}' and is_paid=0 order by log_id desc" );
				if($log_id > 0 && $unifiedOrderResult['err_code'] == 'ORDERPAID'){
					order_paid ( $log_id, 2 );
				}
				return "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
			}
			$product_url = $unifiedOrderResult["code_url"];
			return "<img src='http://qr.liantu.com/api.php?text=" . $product_url . "' alt='扫描进行支付'><iframe src='weixin_order_check.php?oid={$order['order_id']}' style='display:none'></iframe>";
		}
	}
}
?>