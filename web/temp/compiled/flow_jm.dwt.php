<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://xjd.local/" />
<meta name="Generator" content="68ECSHOP v4_2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link rel="stylesheet" type="text/css" href="themes/68ecshopcom_360buy/css/68ecshop_commin.css" />
<link rel="stylesheet" type="text/css" href="themes/68ecshopcom_360buy/css/style_jm.css" />
<script>
var pay_balance_id = <?php echo $this->_var['pay_balance_id']; ?>;//保存余额支付的id做为js全局变量
</script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery-1.6.2.min.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,shopping_flow.js')); ?>
</head>
<body>
 

<div id="popup_window" style="position:fixed;display:none;z-index:9999;">
<label>请输入余额支付密码:</label>
<input id="surplus_password_input" class='inputBg' type="password" />
<input type="button" onclick="end_input_surplus()" value="确定" class='bnt_blue_1 btn_pay1' />
<input type="button" onclick="cancel_input_surplus()" value="取消" class='bnt_blue_1 btn_pay2' />
</div>

<div id="site-nav" style="position:relative;"> <?php echo $this->fetch('library/user_header.lbi'); ?>
  <div class="headerLayout" style="padding-top:15px; padding-bottom:5px;">
    <div class="headerCon ">
      <h1 id="mallLogo" style="padding-top:10px;"> <a href="/" class="header-logo"><img src="themes/68ecshopcom_360buy/images/header/logo.jpg" /></a></h1>
      <div class="header-extra"> </div>
    </div>
  </div>
  <div class="blank"></div>
  <div class="block_jm">
  <?php if ($this->_var['step'] == "cart"): ?>
  <div id="A_Stepbar" class="flowstep">
    <ol class="flowstep-5">
      <li class="step-first">
        <div class="step-done">
          <div class="step-name">查看购物车</div>
          <div class="step-no"></div>
        </div>
      </li>
      <li>
        <div class="step-name">拍下商品</div>
        <div class="step-no">2</div>
      </li>
      <li>
        <div class="step-name">付款</div>
        <div class="step-no">3</div>
      </li>
      <li>
        <div class="step-name">确认收货</div>
        <div class="step-no">4</div>
      </li>
      <li class="step-last">
        <div class="step-name">评价</div>
        <div class="step-no">5</div>
      </li>
    </ol>
  </div>
   
  
  <?php echo $this->smarty_insert_scripts(array('files'=>'showdiv.js')); ?> 
  <script type="text/javascript">
  <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
    var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </script>
  <div class="blank5"></div>
  <div class="flowBox_jm" style="margin-top:10px;">
    <div class="title_jm" >
      <table cellpadding=0 cellspacing=0 width="100%" border=0>
        <tr> 
          <td width="8%" align=center><input type="checkbox" autocomplete="off" id="chkAll" name="chkAll" checked=true  onclick="return chkAll_onclick()" style="height:28px;vertical-align:middle;" >
            全选</td>
          
          <td width="37%" align=center>产品</td>
          <td width="15%" align=center>数量</td>
          <td width="15%" align=center>本店价</td>
          <td width="15%" align=center>小计</td>
          <td width="10%" align=center>操作</td>
        </tr>
      </table>
    </div>
    <form id="formCart1" name="formCart" method="post" action="flow.php">
      <?php echo $this->fetch('library/cart_supplier_goods.lbi'); ?>
      <input type="hidden" name="step" id="actname" value="update_cart" />
    </form>
    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="6"  style="border-top:1px solid #ddd;">
      <tr>
        <td width="150"><a href="./" class="continue_buy">继续购物</a></td>
        <td align="right" width="80"><a href="flow.php?step=clear" class="jmclear"><font color=#aaaaaa>清空购物车 </font></a></td>
        <td align="right" id='cart_money_info'> 应付总额： <span><?php echo $this->_var['shopping_money']; ?></span><?php if ($this->_var['show_marketprice']): ?>，<?php echo $this->_var['market_price_desc']; ?><?php endif; ?></td>
        <td align="right" width="150"><a href="javascript:void(0);" onclick="return selcart_submit();" class="jmcheckout" style="color:#ffffff">去结算</a></td>
      </tr>
    </table>
     
    <script type="text/javascript" charset="utf-8">
	function chkAll_onclick() 
	{
		var obj = document.getElementById('chkAll');
		var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
		for (var i=0;i<obj_cartgoods.length;i++)
		{
			var e = obj_cartgoods[i];
			
			if (e.name != 'chkAll'){
				e.checked = obj.checked;
			}
		}
		select_cart_goods();
	}
	function select_cart_goods()
	{
	      var sel_goods = new Array();
	      var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
	      var suppid = document.getElementById('supplierid');
	      var j=0;
	      var c = true;
	      for (i=0;i<obj_cartgoods.length;i++)
	      {
			if(obj_cartgoods[i].checked == true)
			{	
				sel_goods[j] = obj_cartgoods[i].value;
				j++;
			}else{
				c = false;
			}
	      }
	      document.getElementById('chkAll').checked = c;
	      Ajax.call('flow.php', 'act=selcart&sel_goods=' + sel_goods + '&suppid=' + suppid, selcartResponse, 'GET', 'JSON');
	}
	function selcartResponse(res)
	{
	  if (res.err_msg.length > 0)
	  {
            alert(res.err_msg);
	  }
	  else
	  {
	     document.getElementById('cart_money_info').innerHTML = res.result;
		 if(document.getElementById('zk_'+res.suppid)){
	     	document.getElementById('zk_'+res.suppid).innerHTML = res.your_discount;
		 }
	  }
	}
	function selcart_submit()
	{
	      var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
	      var formobj = document.getElementById('formCart1');
	      var j=0;
	      for (i=0;i<obj_cartgoods.length;i++)
	      {
			if(obj_cartgoods[i].checked == true)
			{	
				j++;
			}
	      }
	      if (j>0)
	      {
		
			formobj.action='flow.php?step=checkout';
			document.getElementById('actname').value='checkout';
			formobj.submit();
			return true;
	     }
	     else
	     {		
			alert('您还没有选择商品哦！');
			return false;
	     }
	}
	</script> 
     
     
    <script>
	function add_num(rec_id,goods_id,supp_id,is_package)
	 {
		 
		document.getElementById("goods_number_"+rec_id+"").value++;
		var sel_goods = new Array();
		var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
		var j=0;
	      for (i=0;i<obj_cartgoods.length;i++)
	      {
			if(obj_cartgoods[i].checked == true)
			{	
				sel_goods[j] = obj_cartgoods[i].value;
				j++;
			}
	      }
		var number = document.getElementById("goods_number_"+rec_id+"").value;
		Ajax.call('flow.php', 'step=update_group_cart&sel_goods='+ sel_goods +'&rec_id=' + rec_id +'&number=' + number+'&goods_id=' + goods_id + '&suppid=' + supp_id + '&is_package=' + is_package, changePriceResponse, 'GET', 'JSON');
	 }

	function minus_num(rec_id,goods_id,supp_id,is_package)
	{
		if (document.getElementById("goods_number_"+rec_id+"").value>1)
		{
			document.getElementById("goods_number_"+rec_id+"").value--;
		}
		var sel_goods = new Array();
		var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
		var j=0;
	      for (i=0;i<obj_cartgoods.length;i++)
	      {
			if(obj_cartgoods[i].checked == true)
			{	
				sel_goods[j] = obj_cartgoods[i].value;
				j++;
			}
	      }
		var number = document.getElementById("goods_number_"+rec_id+"").value;
		Ajax.call('flow.php', 'step=update_group_cart&sel_goods='+ sel_goods +'&rec_id=' + rec_id +'&number=' + number+'&goods_id=' + goods_id + '&suppid=' + supp_id + '&is_package=' + is_package, changePriceResponse, 'GET', 'JSON');
	}

function change_price(rec_id,goods_id,is_package)
{	
	var r = /^[1-9]+[0-9]*]*$/;
	var number = document.getElementById("goods_number_"+rec_id+"").value;
	if (!r.test(number))
	{
		alert("您输入的格式不正确！");
		document.getElementById("goods_number_"+rec_id+"").value=document.getElementById("hidden_"+rec_id+"").value;
	}
	else
	{	
		var sel_goods = new Array();
		var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
		var j=0;
	      for (i=0;i<obj_cartgoods.length;i++)
	      {
			if(obj_cartgoods[i].checked == true)
			{	
				sel_goods[j] = obj_cartgoods[i].value;
				j++;
			}
	      }
		Ajax.call('flow.php','step=update_group_cart&sel_goods='+ sel_goods +'&rec_id=' + rec_id +'&number=' + number+'&goods_id=' + goods_id + '&is_package=' + is_package, changePriceResponse, 'GET', 'JSON');
	}
}

function changePriceResponse(result)
{
if(result.error == 1)
{
	alert(result.content);
	document.getElementById("goods_number_"+result.rec_id+"").value =result.number;
	document.getElementById("hidden_"+result.rec_id+"").value =result.number;
}
else if (result.error == 999 )
{
	if (confirm(result.message))
	{
		location.href = 'user.php';
	}
}
else if (result.error == 888 )
{
	alert(result.message);
	document.getElementById("goods_number_"+result.rec_id+"").value =result.number;
	document.getElementById("hidden_"+result.rec_id+"").value =result.number;
}
else
{
	document.getElementById("sel_cartgoods_"+result.rec_id).checked = true;//被操作商品选中
	document.getElementById("hidden_"+result.rec_id+"").value =result.number;
	document.getElementById("goods_price_"+result.rec_id).innerHTML = result.goods_price;//商品价格
	document.getElementById('subtotal_'+result.rec_id).innerHTML = result.subtotal;//商品总价
	document.getElementById('cart_money_info').innerHTML = result.market_amount_desc;//购物车商品总价说明
	document.getElementById('zk_'+result.suppid).innerHTML = result.your_discount;//折扣活动说明
	show_div_text = "恭喜您！ 商品数量修改成功！ ";
	showdiv(document.getElementById("goods_number_"+result.rec_id));
}

}
</script> 
     
    <?php if ($_SESSION['user_id'] > 0): ?> 
    <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js')); ?> 
    <script type="text/javascript" charset="utf-8">
        function collect_to_flow(goodsId)
        {
          var goods        = new Object();
          var spec_arr     = new Array();
          var fittings_arr = new Array();
          var number       = 1;
          goods.spec     = spec_arr;
          goods.goods_id = goodsId;
          goods.number   = number;
          goods.parent   = 0;
          Ajax.call('flow.php?step=add_to_cart', 'goods=' + goods.toJSONString(), collect_to_flow_response, 'POST', 'JSON');
        }
        function collect_to_flow_response(result)
        {
          if (result.error > 0)
          {
            // 如果需要缺货登记，跳转
            if (result.error == 2)
            {
              if (confirm(result.message))
              {
                location.href = 'user.php?act=add_booking&id=' + result.goods_id;
              }
            }
            else if (result.error == 6)
            {
              openSpeDiv(result.message, result.goods_id);
            }
            else
            {
              alert(result.message);
            }
          }
          else
          {
            location.href = 'flow.php';
          }
        }
      </script> 
    <?php endif; ?> 
  </div>
  <div class="blank"></div>
  
  <div class="flowBox_jm">
    <div class="title_jm">
      <ul id="HotBoxTit">
        <li class="curr">购买的还买了</li>
        <li >今日最受欢迎</li>
        <?php if ($this->_var['collection_goods']): ?>
        <li >我的收藏</li>
        <?php endif; ?> 
        <?php if ($this->_var['fittings_list']): ?>
        <li>商品配件</li>
        <?php endif; ?>
      </ul>
    </div>
    <div class="flowHot" id="HotBox" >
      <ul class="curr clearfix">
        <?php if ($this->_var['bestgoods_list']): ?>
        <?php $_from = $this->_var['bestgoods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bestgoods');if (count($_from)):
    foreach ($_from AS $this->_var['bestgoods']):
?>
        <li>
          <p class="pic"><a href="<?php echo $this->_var['bestgoods']['url']; ?>" target="_blank" ><img src="<?php echo $this->_var['bestgoods']['goods_thumb']; ?>" ></a></p>
          <p class="name"><a href="<?php echo $this->_var['bestgoods']['url']; ?>" target="_blank" ><?php echo $this->_var['bestgoods']['goods_name']; ?></a></p>
          <p class="price"><del style="color:#999"><?php echo $this->_var['bestgoods']['market_price']; ?></del></p>
          <p><font class="price"><?php echo $this->_var['bestgoods']['shop_price']; ?></font></p>
          <a class="j_AddCart" href="javascript:addToCart(<?php echo $this->_var['bestgoods']['goods_id']; ?>)"></a> </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php endif; ?>
      </ul>
      <ul class="clearfix">
        <?php if ($this->_var['hotgoods_list']): ?>
        <?php $_from = $this->_var['hotgoods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'hotgoods');if (count($_from)):
    foreach ($_from AS $this->_var['hotgoods']):
?>
        <li>
          <p class="pic"><a href="<?php echo $this->_var['hotgoods']['url']; ?>" target="_blank" ><img src="<?php echo $this->_var['hotgoods']['goods_thumb']; ?>" ></a></p>
          <p class="name"><a href="<?php echo $this->_var['hotgoods']['url']; ?>" target="_blank" ><?php echo $this->_var['hotgoods']['goods_name']; ?></a></p>
          <p class="price"><del style="color:#999"><?php echo $this->_var['hotgoods']['market_price']; ?></del></p>
          <p><font class="price"><?php echo $this->_var['hotgoods']['shop_price']; ?></font></p>
          <a class="j_AddCart" href="javascript:addToCart(<?php echo $this->_var['hotgoods']['goods_id']; ?>)"></a> </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php endif; ?>
      </ul>
      <?php if ($this->_var['collection_goods']): ?>
      <ul class="clearfix">
        <?php $_from = $this->_var['collection_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
        <li>
          <p class="pic"><a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank" ><img src="<?php echo $this->_var['goods']['thumb']; ?>" ></a></p>
          <p class="name"><a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank" ><?php echo $this->_var['goods']['goods_name']; ?></a></p>
          <p class="price"><del style="color:#999"><?php echo $this->_var['goods']['market_price']; ?></del></p>
          <p><font class="price"><?php echo $this->_var['goods']['shop_price']; ?></font></p>
          <a class="j_AddCart" href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)"></a> </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
      <?php endif; ?> 
      <?php if ($this->_var['fittings_list']): ?> 
      <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js')); ?> 
      <script type="text/javascript" charset="utf-8">
  function fittings_to_flow(goodsId,parentId)
  {
    var goods        = new Object();
    var spec_arr     = new Array();
    var number       = 1;
    goods.spec     = spec_arr;
    goods.goods_id = goodsId;
    goods.number   = number;
    goods.parent   = parentId;
    Ajax.call('flow.php?step=add_to_cart', 'goods=' + $.toJSON(goods), fittings_to_flow_response, 'POST', 'JSON');
  }
  function fittings_to_flow_response(result)
  {
    if (result.error > 0)
    {
      // 如果需要缺货登记，跳转
      if (result.error == 2)
      {
        if (confirm(result.message))
        {
          location.href = 'user.php?act=add_booking&id=' + result.goods_id;
        }
      }
      else if (result.error == 6)
      {
        openSpeDiv(result.message, result.goods_id, result.parent);
      }
      else
      {
        alert(result.message);
      }
    }
    else
    {
      location.href = 'flow.php';
    }
  }
  </script>
      <form action="flow.php" method="post">
        <ul class="clearfix">
          <?php $_from = $this->_var['fittings_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'fittings');if (count($_from)):
    foreach ($_from AS $this->_var['fittings']):
?>
          <li>
            <p class="pic"><a href="<?php echo $this->_var['fittings']['url']; ?>" target="_blank" ><img src="<?php echo $this->_var['fittings']['goods_thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['fittings']['name']); ?>" ></a></p>
            <p class="name"><a href="<?php echo $this->_var['fittings']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['fittings']['goods_name']); ?>"><?php echo htmlspecialchars($this->_var['fittings']['short_name']); ?></a></p>
            <p class="price"><del style="color:#999"><?php echo $this->_var['fittings']['shop_price']; ?></del></p>
            <p><font class="price"><?php echo $this->_var['fittings']['fittings_price']; ?></font></p>
            <a class="j_AddCart" href="javascript:fittings_to_flow(<?php echo $this->_var['fittings']['goods_id']; ?>,<?php echo $this->_var['fittings']['parent_id']; ?>)"></a> </li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
      </form>
      <?php endif; ?> 
    </div>
  </div>
  <script type="text/javascript">
	var hotboxtit = document.getElementById("HotBoxTit");
	var hotbox = document.getElementById("HotBox");
	var hottlist = hotboxtit.getElementsByTagName("li");
	var hotlist = hotbox.getElementsByTagName("ul");
	var hottlen = hottlist.length;
	for(var i = 0; i < hottlen; i++)
	{ 
		hottlist[i].pai=i;
		hottlist[i].onmouseover = function(){	
		for(var j=0; j < hottlen; j++){
				var _hott = hottlist[j];
				var _hot =  hotlist[j];
				var ison  =  j==this.pai;
				_hott.className=(ison ? "curr" : "");
				_hot.className= (ison  ?  "curr" : "");
		}
		}
	}
	</script> 
  <?php endif; ?> 
  
  <?php if ($this->_var['step'] == "consignee"): ?> 
  
   
  <?php echo $this->smarty_insert_scripts(array('files'=>'region.js,utils.js')); ?> 
  <script type="text/javascript">
          region.isAdmin = false;
          <?php $_from = $this->_var['lang']['flow_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
          var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

          
          onload = function() {
            if (!document.all)
            {
              document.forms['theForm'].reset();
            }
          }
          
        </script> 
   
  <?php $_from = $this->_var['consignee_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('sn', 'consignee');if (count($_from)):
    foreach ($_from AS $this->_var['sn'] => $this->_var['consignee']):
?>
  <form action="flow.php" method="post" name="theForm" id="theForm" onsubmit="return checkConsignee(this)">
    <?php echo $this->fetch('library/consignee.lbi'); ?>
  </form>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php endif; ?> 
  
  <?php if ($this->_var['step'] == "checkout"): ?>
  <div id="A_Stepbar" class="flowstep">
    <ol class="flowstep-5">
      <li class="step-first">
        <div class="step-done">
          <div class="step-name">查看购物车</div>
          <div class="step-no"></div>
        </div>
      </li>
      <li>
        <div class="step-done">
          <div class="step-name">拍下商品</div>
          <div class="step-no"></div>
        </div>
      </li>
      <li>
        <div class="step-name">付款</div>
        <div class="step-no">3</div>
      </li>
      <li>
        <div class="step-name">确认收货</div>
        <div class="step-no">4</div>
      </li>
      <li class="step-last">
        <div class="step-name">评价</div>
        <div class="step-no">5</div>
      </li>
    </ol>
  </div>
  <div id="bg" class="bg" style="display:none;"></div>
  <?php echo $this->smarty_insert_scripts(array('files'=>'region.js,utils.js')); ?>
  <form action="flow.php" method="post" name="theForm" id="theForm" onsubmit="return checkOrderForm(this)">
    <script type="text/javascript">
        var flow_no_payment = "<?php echo $this->_var['lang']['flow_no_payment']; ?>";
        var flow_no_shipping = "<?php echo $this->_var['lang']['flow_no_shipping']; ?>";
    </script>
    <div class="blank10"></div>
    <div class="checkBox_jm clearfix" >
      <div class="title">1 地址选择</div>
      <div class="address_jm" id="AddressList" > <?php echo $this->fetch('library/address_list.lbi'); ?> </div>
      <div id="popDiv" class="mydiv" style="display:none;">
        <div class="mydiv-l" id="PopAddressTitle">使用新地址</div>
        <div class="mydiv-r" onclick="javascript:closePopDiv()" ></div>
        <div id="PopAddressCon"></div>
      </div>
    </div>
    <script type="text/javascript">
	
	function AddressEdit(aid)
	{	
		if (aid)
		{
			document.getElementById('PopAddressTitle').innerHTML='修改地址';
		}
		else
		{
			document.getElementById('PopAddressTitle').innerHTML='使用新地址';
		}
		Ajax.call('flow.php?act=EditAddress', 'address_id=' + aid, AddressEdit_Response, 'GET', 'JSON');
	}
	function AddressEdit_Response(result)
	{
		var PopAddressCon=document.getElementById('PopAddressCon');
		PopAddressCon.innerHTML= result.content;
		document.getElementById('popDiv').style.display='block';
		document.getElementById('bg').style.display='block';
	}

	function showPopDiv()
	{
		document.getElementById('popDiv').style.display='block';
		document.getElementById('bg').style.display='block';
	}
	function closePopDiv()
	{
		document.getElementById('popDiv').style.display='none';
		document.getElementById('bg').style.display='none';
	}

	function showAddressEdit(obj)
	{
		if (obj.className!='curr')
		{
			obj.className = obj.className == 'xxxxxx' ? '' : 'xxxxxx';
		}
	}
	function selAddress(obj, address_id)
	{
		var addrParent = obj.parentNode;
		var addrYeye = addrParent.parentNode;
		var addrList = addrYeye.getElementsByTagName('li');
		for (i=0;i<addrList.length;i++)
		{
			addrList[i].className='';
		}
		addrParent.className='curr';
		Ajax.call('flow.php?act=selAddress', 'address_id=' + address_id, selAddress_response, 'GET', 'JSON');
	}
	function selAddress_response(result)
	{
		top.location.href = top.location.href;
	}

	function del_Address(address_id)
	{
		Ajax.call('flow.php?act=delAddress', 'address_id=' + address_id, delAddressResponse, 'GET', 'JSON');
	}
	function delAddressResponse(result)
	{
		 if (result.message)
		{
			alert(result.message);
		}

		if (result.error == 0)
		{
			 var layer = document.getElementById('AddressList');

			if (layer)
			{
				layer.innerHTML = result.content;
			}
			if(result.content2)
			{
				document.getElementById("shippingBox").innerHTML='<font color="#ff3300">&nbsp;&nbsp;&nbsp;正在重新导入配送区域，请稍候。。。</font>';
				document.getElementById("shippingBox").innerHTML= '<font style="color:#ff3300">配送区域已经变化，请重新选择物流<br><br></font>'+result.content2;
			}
			document.forms['theForm'].elements['have_consignee'].value=result.have_consignee;
		}
	}

        /**
	* 提交地址信息
	*/
	function submitAddress()
	{
	var frm = document.forms['theForm'];
	var cmt = new Object;
	cmt.address_id       = frm.elements['address_id'].value;
	cmt.consignee       = frm.elements['consignee'].value;
	cmt.address         = frm.elements['address'].value;
	cmt.email           = frm.elements['email'].value;
	cmt.zipcode           = frm.elements['zipcode'].value;
	cmt.country              = 1;//frm.elements['country'].value;
	cmt.province           = frm.elements['province'].value;
	cmt.city         =      frm.elements['city'].value;
	cmt.district         =      frm.elements['district'].value;
	cmt.tel           =  frm.elements['tel_01'].value + "-" + frm.elements['tel_02'].value + (Utils.isEmpty(frm.elements['tel_03'].value) ? "" :  "-" + frm.elements['tel_03'].value);
	cmt.mobile         =      frm.elements['mobile'].value;
	cmt.closediv	   = frm.elements['closediv'].value;
	cmt.shipping_bian	   = frm.elements['shipping_bian'].value;
  	cmt.optionlength = frm.elements['district'].length;

  if (cmt.consignee.length == 0)
   {
	alert('收件人不能为空！');
	return false;
   }
   if(cmt.optionlength > 1)
   {
	   if (cmt.province == '0' ||  cmt.city == '0'  || cmt.district == '0' )
	   {
		alert('所在地区不完整！');
		return false;
	   }
   }
   else
   {
	   if (cmt.province == '0' ||  cmt.city == '0' )
	   {
		alert('所在地区不完整！');
		return false;
	   }

   }
   /* 邮箱不是必填项
   if (cmt.email.length == 0)
   {
		alert('邮箱地址不能为空');
		return false;
   }
   */
   if (cmt.email.length > 0 && (!Utils.isEmail(cmt.email)))
   {
		alert('邮箱地址不正确');
		return false;
   }
   if (cmt.address.length == 0)
   {
	alert('街道地址不能为空！');
	return false;
   }
   
   if (cmt.mobile.length == 0 && (cmt.tel.length == 0 || cmt.tel == '--' || cmt.tel == '-'))
   {
	alert('手机号码和固定电话必须填写至少一项！');
	return false;
   }
   if (cmt.mobile.length>0)
  {
    var reg = /^1[34578][0-9]\d{8}$/;
    if (!Utils.isMobile(cmt.mobile))
    {
	alert('手机号码格式不正确！');
	return false;
    }
  }
  if (cmt.tel.length>0 && cmt.tel != '--' && cmt.tel != '-')
  {
    var reg = /^[\d|\-|\s]+$/;
    if (!Utils.isTel(cmt.tel))
    {
        alert('固定电话格式不正确！');
	return false;
    }
  }

   Ajax.call('flow.php?act=saveAddress', 'address=' + $.toJSON(cmt), addressResponse, 'POST', 'JSON');
   
}

/* 处理提交地址的反馈信息  */
  function addressResponse(result)
  {
    if (result.message)
    {
      alert(result.message);
    }else{
	top.location.href = top.location.href;
    }
    /*
    if (result.error == 0)
    {
	var layer = document.getElementById('AddressList');
	if (layer)
	{
		layer.innerHTML = result.content;
	}
	if(result.content2)
	{
		document.getElementById("shippingBox").innerHTML='<font color="#ff3300">&nbsp;&nbsp;&nbsp;正在重新导入配送区域，请稍候。。。</font>';
		document.getElementById("shippingBox").innerHTML= '<font style="color:#ff3300">配送区域已经变化，请重新选择物流<br><br></font>'+result.content2;
	}
	document.forms['theForm'].elements['have_consignee'].value='1';
	if (result.closediv == '1')
	{
		closePopDiv();
	}
    }*/

  }
	
	</script> 
    
    <div class="checkBox_jm">
      <div class="title">2 送货时间 <span class="songhuo">送货时间仅作参考，快递公司会尽量满足您的要求</span></div>
      <div class="timebox">
        <ul>
          <li class="curr" id="time_id_1" onClick="javascript:setTimeSh('1');">
            <input id="time_delivery1" type="radio" name="best_time" value="仅工作日送货" checked=checked>
            <label for="time_delivery1">仅工作日送货</label>
          </li>
          <li id="time_id_2" onClick="javascript:setTimeSh('2');">
            <input id="time_delivery2" type="radio" name="best_time" value="仅周末送货" >
            <label for="time_delivery2">仅周末送货</label>
          </li>
          <li id="time_id_3" onClick="javascript:setTimeSh('3')" >
            <input id="time_delivery3" type="radio" name="best_time" value="工作日/周末/假日均可" >
            <label for="time_delivery3">工作日/周末/假日均可</label>
          </li>
          <li id="time_id_4" style="position:relative;" onmouseover="if(this.className=='curr' || this.className=='curr2'){this.className='curr';}else{this.className='cur2';}"  onmouseout="if(this.className=='curr'){this.className='curr2';}else{this.className='cur';}" onClick="javascript:setTimeSh('4')" >
            <input type="radio" name="best_time" value="" id="definetime_input" >
            <label for="definetime_input" id="definetime">指定送货时间</label>
            <div class="seltimebox" id="seltimebox">
              <table cellpadding=5 cellspacing=0 width="100%" >
                <tr bgcolor=#ffffff>
                  <td style="padding-left:10px">时间段</td>
                  <?php $_from = $this->_var['week_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'week');if (count($_from)):
    foreach ($_from AS $this->_var['week']):
?>
                  <td align=center><?php echo $this->_var['week']['name']; ?><br>
                    <?php echo $this->_var['week']['week']; ?></td>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </tr>
                <tr bgcolor=#ffffff>
                  <td style="padding-left:10px">9:00--15:00</td>
                  <?php $_from = $this->_var['week_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'week');if (count($_from)):
    foreach ($_from AS $this->_var['week']):
?>
                  <td align=center><?php if ($this->_var['week']['time1']): ?><a href="javascript:void(0);" name="<?php echo $this->_var['week']['name']; ?> <?php echo $this->_var['week']['week']; ?> 9:00--15:00" onclick="selTimeSh(this)" >可选</a><?php else: ?>&nbsp;<?php endif; ?></td>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </tr>
                <tr bgcolor=#ffffff>
                  <td style="padding-left:10px">15:00--19:00</td>
                  <?php $_from = $this->_var['week_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'week');if (count($_from)):
    foreach ($_from AS $this->_var['week']):
?>
                  <td align=center><?php if ($this->_var['week']['time2']): ?><a href="javascript:void(0);" name="<?php echo $this->_var['week']['name']; ?> <?php echo $this->_var['week']['week']; ?> 15:00--19:00" onclick="selTimeSh(this)" >可选</a><?php else: ?>&nbsp;<?php endif; ?></td>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </tr>
                <tr bgcolor=#ffffff>
                  <td style="padding-left:10px">19:00--22:00</td>
                  <?php $_from = $this->_var['week_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'week');if (count($_from)):
    foreach ($_from AS $this->_var['week']):
?>
                  <td align=center><?php if ($this->_var['week']['time3']): ?><a href="javascript:void(0);" name="<?php echo $this->_var['week']['name']; ?> <?php echo $this->_var['week']['week']; ?> 19:00--22:00" onclick="selTimeSh(this)" >可选</a><?php else: ?>&nbsp;<?php endif; ?></td>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </tr>
              </table>
            </div>
          </li>
        </ul>
      </div>
      <div class="blank"></div>
    </div>
    
    <div class="checkBox_jm">
      <div class="title">3 商品清单</div>
      	<table border=0 cellpadding=0 cellspacing=0 width="100%" class="checkgoods">
        <tr>
          <th width='50%' align=left class="tdone">商品</th>
          <th>数量</th>
          <th>单价</th>
          <th>小计</th>
        </tr>
        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goodsinfo');$this->_foreach['glist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['glist']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['goodsinfo']):
        $this->_foreach['glist']['iteration']++;
?>
        <tr>
            <td colspan=4 style="background:#FAFAFA; border-top:2px solid #d9d9d9; font-weight:bold; padding:5px 10px;" > <?php echo $this->_var['goodsinfo']['goodlist']['0']['seller']; ?></td>
        </tr>
        <?php $_from = $this->_var['goodsinfo']['goodlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['name']['iteration']++;
?>
        <tr>
          <td width='50%' <?php if (($this->_foreach['name']['iteration'] <= 1)): ?>style="border-top:none;"<?php endif; ?>><?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?>
            
            <div class="thumb_name">
              <dl >
                <dt> <a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" style="border:1px solid #ddd;" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" /></a> </dt>
                <dd> <a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank" class="f6"><?php echo $this->_var['goods']['goods_name']; ?></a> <br>
                  <font class="attrname"><?php echo nl2br($this->_var['goods']['goods_attr']); ?></font> 
                  <?php if ($this->_var['goods']['parent_id'] > 0): ?> 
                  <span ><?php echo $this->_var['lang']['accessories']; ?></span> 
                  <?php endif; ?> 
                  <?php if ($this->_var['goods']['is_gift'] > 0): ?> 
                  <span><?php echo $this->_var['lang']['largess']; ?></span> 
                  <?php endif; ?> 
                </dd>
              </dl>
            </div>
            
            <?php elseif ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] == 'package_buy'): ?>
            
            <div class="thumb_name">
              <dl >
                <dt><img src="themes/<?php echo $this->_var['template_dir']; ?>/images/jmpic/ico_cart_package.gif" border="0" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" /></dt>
                <dd> <?php echo $this->_var['goods']['goods_name']; ?><font style="color:#FF0000;">（<?php echo $this->_var['lang']['remark_package']; ?>）</font>
                  <div style="display:block;position:relative;"> <a  href="javascript:void(0)" onclick="setSuitShow(<?php echo $this->_var['goods']['goods_id']; ?>)" ><span class="package">商品明细</span></a>
                    <div id="suit_<?php echo $this->_var['goods']['goods_id']; ?>" style="float:left;position:absolute;background:#fff;width:500px;top:25px;left:0;border:1px solid #31c8e3;padding:10px 0;display:none;">
                      <table cellpadding=10 cellspacing=5 width="100%"  style="padding:0;margin:0;">
                        <?php $_from = $this->_var['goods']['package_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'package_goods_list');$this->_foreach['package_goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['package_goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['package_goods_list']):
        $this->_foreach['package_goods_list']['iteration']++;
?>
                        <tr >
                          <td width="60px" <?php if (! ($this->_foreach['package_goods_list']['iteration'] == $this->_foreach['package_goods_list']['total'])): ?>style="border-bottom:1px dashed #bbb;"<?php endif; ?>><img src="<?php echo $this->_var['package_goods_list']['goods_thumb']; ?>" width="40" height="40"></td>
                          <td <?php if (! ($this->_foreach['package_goods_list']['iteration'] == $this->_foreach['package_goods_list']['total'])): ?>style="border-bottom:1px dashed #bbb;"<?php endif; ?>><a href="goods.php?id=<?php echo $this->_var['package_goods_list']['goods_id']; ?>" target="_blank" class="fpack"><?php echo sub_str($this->_var['package_goods_list']['goods_name'],20); ?></a></td>
                          <td <?php if (! ($this->_foreach['package_goods_list']['iteration'] == $this->_foreach['package_goods_list']['total'])): ?>style="border-bottom:1px dashed #bbb;"<?php endif; ?>><div style="float:left;border:1px solid #bbb;background:#ddd;width:20px;text-align:center;padding:5px 10px;"><?php echo $this->_var['package_goods_list']['goods_number']; ?></div></td>
                          <td align="center" <?php if (! ($this->_foreach['package_goods_list']['iteration'] == $this->_foreach['package_goods_list']['total'])): ?>style="border-bottom:1px dashed #bbb;"<?php endif; ?>><?php echo $this->_var['package_goods_list']['shop_price']; ?></td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                      </table>
                    </div>
                  </div>
                </dd>
              </dl>
            </div>
            
            <?php else: ?> 
            <?php echo $this->_var['goods']['goods_name']; ?> 
            <?php endif; ?></td>
          <td align=center <?php if (($this->_foreach['name']['iteration'] <= 1)): ?>style="border-top:none;"<?php endif; ?>><?php echo $this->_var['goods']['goods_number']; ?></td>
          <td  align=center class="price_font" <?php if (($this->_foreach['name']['iteration'] <= 1)): ?>style="border-top:none;"<?php endif; ?>><?php echo $this->_var['goods']['formated_goods_price']; ?></td>
          <td  align=center class="price_font" <?php if (($this->_foreach['name']['iteration'] <= 1)): ?>style="border-top:none;"<?php endif; ?>><?php echo $this->_var['goods']['formated_subtotal']; ?></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        <?php if ($this->_var['goodsinfo']['zhekou']): ?>
        <tr>
            <td colspan="4" bgcolor="#ffffff" align=right style="padding:12px 15px 12px 0;"><?php if ($this->_var['goodsinfo']['zhekou']): ?><?php echo $this->_var['goodsinfo']['zhekou']['your_discount']; ?><?php endif; ?></td>
        </tr>
        <?php endif; ?> 
		<?php if ($this->_var['goodsinfo']['shipping_html']): ?>
        <tr>
			<td colspan=4 bgcolor="#ffffff" align="left" class="shipping_type">
			<?php echo $this->_var['goodsinfo']['shipping_html']; ?>
			
			<span id='picktxt<?php echo $this->_var['key']; ?>'>
			
			</span>   
			
			<p class="shipping_desc" id="desc_<?php echo $this->_var['key']; ?>">您可以选择离您最近的自提点上门提货：运费5元，满99元免邮</p>
			<script>selectShipping($('#pay_ship_<?php echo $this->_var['goodsinfo']['goodlist']['0']['supplier_id']; ?>').val(),<?php echo $this->_var['key']; ?>);</script>
			</td>
		</tr>
		<?php endif; ?>
        <?php if (( $this->_var['allow_use_bonus'] || $this->_var['allow_use_integral'] ) && $this->_var['goodsinfo']['goodlist']): ?>
        <tr>
            <td colspan="4" bgcolor="#ffffff" align=left style="padding:12px 0 12px 30px;"><div class="checkout_other"> <a class="jmbag" href="javascript:void(0);" onclick="showCheckoutOther(this);"><span>+</span>使用店铺优惠券</a>
              <table class="subbox_other sub_bonus" width="100%">
                <?php if ($this->_var['allow_use_bonus']): ?>
                <tr>
                  <td  align=right width="120">使用店铺优惠券：</td>
                  <td><select name="bonus[<?php echo $this->_var['key']; ?>]" onchange="changeBonus(this.value,<?php echo $this->_var['key']; ?>)" id="ECS_BONUS_<?php echo $this->_var['key']; ?>" class="otherinput">
                      <option value="0" <?php if ($this->_var['order']['bonus_id'] == 0): ?>selected<?php endif; ?>><?php echo $this->_var['lang']['please_select']; ?></option>
                      <?php $_from = $this->_var['goodsinfo']['redbag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bonus');if (count($_from)):
    foreach ($_from AS $this->_var['bonus']):
?>
                      <option value="<?php echo $this->_var['bonus']['bonus_id']; ?>" <?php if ($this->_var['order']['bonus_id_info'] [ $this->_var['key'] ] == $this->_var['bonus']['bonus_id']): ?>selected<?php endif; ?>><?php echo $this->_var['bonus']['type_name']; ?>[<?php echo $this->_var['bonus']['bonus_money_formated']; ?>]</option>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                      
                    </select></td>
                  <td>&nbsp; 或 &nbsp;<a href="javascript:void(0);" onclick="javascript:document.getElementById('Bonus_span_<?php echo $this->_var['key']; ?>').style.display='block';document.getElementById('Bonus_a_<?php echo $this->_var['key']; ?>').style.display='none';" class="a_other1_h" id="Bonus_a_<?php echo $this->_var['key']; ?>">直接输入优惠券号</a></td>
                  <td><label id="Bonus_span_<?php echo $this->_var['key']; ?>" style="display:none;">
                      <input name="bonus_sn[<?php echo $this->_var['key']; ?>]" id="bonus_sn_<?php echo $this->_var['key']; ?>" type="text"  size="15" value="<?php if ($this->_var['order']['bonus_sn_info'] [ $this->_var['key'] ]): ?><?php echo $this->_var['order']['bonus_sn_info'][$this->_var['key']]; ?><?php else: ?>输入优惠券<?php endif; ?>" onfocus="if (value =='输入优惠券'){value =''}" onblur="if (value ==''){value='输入优惠券'}" style="height:22px;" />
                      <input name="validate_bonus" type="button" value="使用" onclick="validateBonus(document.getElementById('bonus_sn_<?php echo $this->_var['key']; ?>').value,<?php echo $this->_var['key']; ?>)" class="BonusButton" />
                    </label></td>
                </tr>
                <?php endif; ?> 
                <?php if ($this->_var['allow_use_integral']): ?>
                <tr>
                  <td  align=right width="80">使用积分：</td>
                  <td ><input name="integral[<?php echo $this->_var['key']; ?>]" type="text" class="otherinput2" id="ECS_INTEGRAL_<?php echo $this->_var['key']; ?>" onblur="changeIntegral(this.value,<?php echo $this->_var['key']; ?>)" value="<?php echo empty($this->_var['order']['integral_info'][$this->_var['key']]) ? '0' : $this->_var['order']['integral_info'][$this->_var['key']]; ?>"  /></td>
                  <td colspan=2><span id="ECS_INTEGRAL_NOTICE_<?php echo $this->_var['key']; ?>" class="notice"></span></td>
                </tr>
                <?php endif; ?>
              </table>
            </div></td>
        </tr>
        <?php endif; ?> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </table>
        <table border=0 cellpadding=0 cellspacing=0 width="100%" class="checkgoods">
		<?php if ($this->_var['inv_content_list']): ?>
          <tr>
            <td colspan=4 class="tdother2">
              <div class="checkout_other" > <a class="jmbag" href="javascript:void(0);" onclick="showCheckoutOther(this);"><span>+</span>开发票</a> 
                
                <table class="subbox_other" width="100%">
                  <?php if ($this->_var['inv_content_list']): ?>
                  <tbody width="100%" cellpadding="5" cellspacing="0">
                    <tr>
                      <td align=right ><input name="need_inv" type="checkbox" id="ECS_NEEDINV" onclick="changeNeedInv()" value="1" class="checkbox" />
                        <label class="mar-b">开发票：</label></td>
                      <td align=left colspan="2"><select name="inv_type" id="ECS_INVTYPE" <?php if ($this->_var['order']['need_inv'] != 1): ?>disabled="true"<?php endif; ?> onchange="changeNeedInv()" style="width:145px;height:28px;">
              <option value="0">请选择发票类型</option>
              
<?php echo $this->html_options(array('options'=>$this->_var['inv_type_list'],'selected'=>$this->_var['order']['inv_type'])); ?>

                        </select>
                        &nbsp;&nbsp;
                        <select name="inv_content" id="ECS_INVCONTENT" <?php if ($this->_var['order']['need_inv'] != 1): ?>disabled="true"<?php endif; ?>  onchange="changeNeedInv()" style="width:145px;height:28px;">
                          <option value="0">请选择发票内容</option>
                          
                
                    
				<?php echo $this->html_options(array('values'=>$this->_var['inv_content_list'],'output'=>$this->_var['inv_content_list'],'selected'=>$this->_var['order']['inv_content'])); ?>
				
                  
              
                        </select></td>
                    </tr>
                  </tbody>
                  <?php endif; ?> 
                  
                  <tbody id='vat_invoice_tbody' style='display:none;' width="100%" cellpadding="5" cellspacing="0" >
                    <tr>
                      <td colspan="3" align='left'><strong style='font-size:16px;'>公司信息</strong></td>
                    </tr>
                    <tr>
                      <td align=right><em style='color:#e4393c'>*</em>单位名称：</td>
                      <td colspan="2"><input name='vat_inv_company_name' type='text' class="otherinput2" /></td>
                    </tr>
                    <tr>
                      <td align=right><em style='color:#e4393c'>*</em>纳税人识别号：</td>
                      <td width="300" style="width:300px;"><input name='vat_inv_taxpayer_id' type='text'  onblur='javascript:check_taxpayer_id(this,"taxpayer_notice")' class="otherinput2" /></td>
                      <td>&nbsp;<span id='taxpayer_notice' style='font-size:12px;color:#f00;'></span></td>
                    </tr>
                    <tr>
                      <td align=right><em style='color:#e4393c'>*</em>注册地址：</td>
                      <td colspan="2"><input name='vat_inv_registration_address' type='text' class="otherinput2" /></td>
                    </tr>
                    <tr>
                      <td align=right><em style='color:#e4393c'>*</em>注册电话：</td>
                      <td colspan="2"><input name='vat_inv_registration_phone' type='text' class="otherinput2" /></td>
                    </tr>
                    <tr>
                      <td align=right><em style='color:#e4393c'>*</em>开户银行：</td>
                      <td colspan="2"><input name='vat_inv_deposit_bank' type='text' class="otherinput2" /></td>
                    </tr>
                    <tr>
                      <td align=right><em style='color:#e4393c'>*</em>银行账户：</td>
                      <td><input name='vat_inv_bank_account' type='text' onblur='javascript:check_bank_account(this,"bank_account_notice")' class="otherinput2" /></td>
                      <td>&nbsp;<span id='bank_account_notice' style='font-size:12px;color:#f00;'></span></td>
                    </tr>
                    <tr>
                      <td colspan="3" align='left' style="padding:10px 0px"><strong style='font-size:16px;'>收票人信息</strong></td>
                    </tr>
                    <tr>
                      <td align=right><em style='color:#e4393c'>*</em>收票人姓名：</td>
                      <td colspan="2"><input name='inv_consignee_name' type='text' class="otherinput2" /></td>
                    </tr>
                    <tr>
                      <td align=right><em style='color:#e4393c'>*</em>收票人手机：</td>
                      <td><input name='inv_consignee_phone' type='text' onblur='javascript:check_phone_number(this,"phone_number_notice")' class="otherinput2" /></td>
                      <td>&nbsp;<span id='phone_number_notice' style='font-size:12px;color:#f00;'></span></td>
          </tr>
          <tr>
            <td align=right><em style='color:#e4393c'>*</em>收票人省份：</td>
            <td colspan='2'><input type="hidden" name="country" value="1">
              <select name="inv_consignee_province" id="selProvinces" onchange="region.changed(this, 2, 'selCities');"  style="width:155px;height:25px;border:1px solid #ccc;">
                <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['1']; ?></option>
                <?php $_from = $this->_var['province_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
                <option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['address']['province'] == $this->_var['province']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </select>
              <select name="inv_consignee_city" id="selCities" style="border: 1px solid rgb(204, 204, 204); border-image: none; width: 70px; height: 25px;" onchange="region.changed(this, 3, 'selDistricts');">
                <option value="0">请选择</option>
              </select>
              <select name="inv_consignee_district" id="selDistricts" style="border: 1px solid rgb(204, 204, 204); border-image: none; width: 70px; height: 25px;display:none;">
                <option value="0">请选择</option>
              </select></td>
          </tr>
          <tr>
            <td align=right><em style='color:#e4393c'>*</em>详细地址：</td>
                      <td colspan='2'><input name='inv_consignee_address' type='text' class="otherinput2" /></td>
                    </tr>
                  </tbody>
                  
                  <tbody id='normal_invoice_tbody' style='display:none'>
                    <tr>
                      <td align=right>发票抬头：</td>
                      <td colspan="2"><input id='individual_inv' type='radio' onclick='changeNeedInv()' name='inv_payee_type' value='individual' checked='true' style="vertical-align:middle"/>
                        <label for='individual_inv' style="vertical-align:middle">个人</label>
                        <input id='unit_inv' type='radio' onclick='changeNeedInv()' name='inv_payee_type' value='unit' style="vertical-align:middle"/>
                        <label for='unit_inv' style="vertical-align:middle">单位</label>
                        &nbsp;&nbsp;
                        <input id='ECS_INVPAYEE' name='inv_payee' class="otherinput2" style='display:none; vertical-align:middle' /></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </td>
          </tr>
          <?php endif; ?>
          <?php if ($this->_var['how_oos_list']): ?>
          <tr>
            <td colspan=4 class="tdother2">
              <div class="checkout_other" > 
              	<a class="jmbag" href="javascript:void(0);" onclick="showCheckoutOther(this);"><span>+</span>缺货处理</a> 
                <table class="subbox_other" width="100%">
                	
                  <tbody width="100%" cellpadding="5" cellspacing="0">
                    <tr>
                      <td align=right width="100">缺货处理：</td>
                      <td colspan='4'><?php $_from = $this->_var['how_oos_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('how_oos_id', 'how_oos_name');if (count($_from)):
    foreach ($_from AS $this->_var['how_oos_id'] => $this->_var['how_oos_name']):
?>
                        
                        <label>
                          <input name="how_oos" type="radio" value="<?php echo $this->_var['how_oos_id']; ?>" <?php if ($this->_var['order']['how_oos'] == $this->_var['how_oos_id']): ?>checked<?php endif; ?> onclick="changeOOS(this)" />
                          <?php echo $this->_var['how_oos_name']; ?></label>
                        
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </td>
          </tr>
          <?php endif; ?>
          <tr>
            <td colspan=4 class="tdother2"><div class="checkout_other" > <a class="jmbag" href="javascript:void(0);" onclick="showCheckoutOther(this);"><span>+</span>订单附言</a>
                <table class="subbox_other" width="100%">
                  <tbody width="100%" cellpadding="5" cellspacing="0">
                    <tr>
                      <td align=right width="100" valign=top>订单附言：</td>
                      <td colspan='4'><textarea name="postscript" cols="80" rows="3" id="postscript" style="border:1px solid #ccc;"><?php echo htmlspecialchars($this->_var['order']['postscript']); ?></textarea></td>
                    </tr>
                  </tbody>
                </table>
              </div></td>
          </tr>
          <script type="text/javascript">
		var fapiao_con = document.getElementById('ECS_INVCONTENT');
		if (fapiao_con.value=='0')
		{
			document.getElementById('ECS_INVPAYEE').disabled=true;
		}
		else
		{
			document.getElementById('ECS_INVPAYEE').disabled=false;
		}
		</script>
	<?php if ($this->_var['allow_use_surplus']): ?>
          <tr>
            <td colspan=4 class="tdother2">
            	<div class="allow_user_surplus">
        			<p>
                    	<input type="checkbox" id="issurplus" onclick="checkboxOnclick(this)" style="vertical-align:middle; cursor:pointer" />
                    	<span class="is_user_surplus">使用账户余额支付</span>
                    </p>
        			<div id="allow_user_surplus">
        				<span class="surplus_desc"><input name="surplus" type="text" class="surplus" id="ECS_SURPLUS"  value="0" onblur="changeSurplus(this.value);" />&nbsp;&nbsp;元</span>
            			您当前的可用余额为:<span class="your_surplus"><?php echo empty($this->_var['your_surplus']) ? '0' : $this->_var['your_surplus']; ?> </span>
                        <span id="ECS_SURPLUS_NOTICE_<?php echo $this->_var['key']; ?>" class="notice"></span>
            			<?php if ($this->_var['is_surplus_open'] == 0): ?><span class="open_surplus">点此<a href="security.php" target="_blank">开启余额安全支付</a></span><?php endif; ?>
        			</div>
				<script type="text/javascript">
				function checkboxOnclick(checkbox){ 
					var surplus = <?php echo empty($this->_var['your_surplus']) ? '0' : $this->_var['your_surplus']; ?>;
					if ( checkbox.checked == true){
						document.getElementById("allow_user_surplus").style.display = "block";
						changeSurplus(surplus);
					}else{
						document.getElementById("allow_user_surplus").style.display = "none";
						changeSurplus(0);
					}
				}
				</script>
        	  </div>
            </td>
          </tr>
	<?php endif; ?>
        </table>
        <div class="blank10"></div>
        <table cellpadding=0 cellspacing=0 width="100%" >
          <tr>
            <td align=right><?php echo $this->fetch('library/order_total.lbi'); ?></td>
          </tr>
        </table>
      </div>
    <script type="text/javascript">
	
	function showCheckoutOther(obj)
	{
		var otherParent = obj.parentNode;
		otherParent.className = (otherParent.className=='checkout_other') ? 'checkout_other2' : 'checkout_other';
		var spanzi = obj.getElementsByTagName('span')[0];
		spanzi.innerHTML= spanzi.innerHTML == '+' ? '-' : '+';
	}
	
      </script> 
    
    <div class="checkBox_jm" id="pay_div">
      <div class="title">4 支付方式</div>
      <ul class="payment_tab_jm" id="payment_tab">
        <?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');$this->_foreach['payment_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['payment_list']['total'] > 0):
    foreach ($_from AS $this->_var['payment']):
        $this->_foreach['payment_list']['iteration']++;
?> 
        
        <?php if ($this->_var['payment']['pay_code'] == 'alipay_bank' || ( $this->_var['payment']['pay_code'] == 'cod' && $this->_var['is_pre_sale'] != 1 ) || $this->_var['payment']['pay_code'] == 'pup'): ?>
        <li  onclick="selPayment(this)" >
          <label style="cursor:pointer;"><input style="cursor:default;" type="radio" isCod="<?php echo $this->_var['payment']['is_cod']; ?>" isPickup="<?php echo $this->_var['payment']['is_pickup']; ?>" onclick="selectPayment(this)" <?php if ($this->_var['cod_disabled'] && $this->_var['payment']['is_cod'] == "1"): ?>disabled="true"<?php endif; ?> <?php if ($this->_var['payment']['pay_code'] == 'alipay_bank'): ?>id="alipay_bank_input"<?php endif; ?> name="payment" value="<?php echo $this->_var['payment']['pay_id']; ?>" >
          <strong><?php if ($this->_var['payment']['pay_code'] == $this->_var['pickup_code'] && $this->_var['has_pickup_point'] == 0): ?>(<?php echo $this->_var['lang']['empty_pickup_point']; ?>)<?php endif; ?></strong> <?php if ($this->_var['payment']['pay_code'] == 'alipay_bank'): ?>支付宝网银直连<?php else: ?><?php echo $this->_var['payment']['pay_name']; ?><?php endif; ?></label>
          <?php if ($this->_var['payment']['pay_code'] == 'alipay_bank'): ?>
          <div class="payment_subbox"> <?php echo $this->fetch('library/alipay_bank.lbi'); ?> </div>
          <?php endif; ?> </li>
        <?php endif; ?> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <li  onclick="selPayment(this)">
          <label style="cursor:pointer;"><input style="cursor:default;" type="radio" onclick="selectPayment(this)" isCod="0" name="payment"  id="payment_other_input" value="0" > 支付宝/快钱/财付通/其他支付</label>
          <div class="payment_subbox">
            <ul >
              <?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');$this->_foreach['payment_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['payment_list']['total'] > 0):
    foreach ($_from AS $this->_var['payment']):
        $this->_foreach['payment_list']['iteration']++;
?> 
              <?php if ($this->_var['payment']['pay_code'] != 'alipay_bank' && $this->_var['payment']['pay_code'] != 'cod' && $this->_var['payment']['pay_code'] != 'pup' && $this->_var['payment']['pay_code'] != 'balance'): ?>
              <label style="cursor:pointer;"><li><input style="cursor:default;" type="radio" name="payment_other" onclick="selectPayment(this);document.getElementById('payment_other_input').value=this.value;" value="<?php echo $this->_var['payment']['pay_id']; ?>" ><img align="absmiddle" src="themes/68ecshopcom_360buy/images/jmpic/pay_<?php echo $this->_var['payment']['pay_code']; ?>.gif" alt="<?php echo $this->_var['payment']['pay_name']; ?>" /></li></label>
              <?php endif; ?> 
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
          </div>
        </li>
      </ul>
    </div>
    <script type="text/javascript">
	
	function setTimeSh(id)
	{
	    for(i=1;i<=4;i++)
	    {
		document.getElementById('time_id_'+i).className='';
	    }
	    var timeid = document.getElementById('time_id_'+id);
	    timeid.className = 'curr';
	}
	function selTimeSh(obj)
	{
		document.getElementById('definetime_input').checked =true;
		document.getElementById('definetime').innerHTML = "指定送货时间 <font color=#ff3300>"+ obj.name +"</font>";
		document.getElementById('definetime_input').value = "指定送货时间 "+ obj.name ;
	}
	function selPayment(obj)
	{
		var con_country = document.forms['theForm'].elements['have_consignee'].value;
		if ( con_country=='0' )
		{
			alert('请先选择配送地址！');
			obj.checked= false;
			return ;
		}
		var paymentList = obj.getElementsByTagName('input');
		if (paymentList[0].disabled !=true)
		{
		var payParent = obj.parentNode;		
		var payList = payParent.getElementsByTagName('li');
		for(i=0;i<payList.length;i++)
		{
			payList[i].className='';
		}
		obj.className='seled';
		
		for (var i=0;i<paymentList.length;i++)
		{
			if (paymentList[i].name=='payment' && !paymentList[i].disabled)
			{
				paymentList[i].checked= true;
			}
		}
		}
	}
	
	</script>
    <div class="flowBox_jm clearfix" style="border:none;padding-bottom:20px;">
      <div  style="float:left;width:40%;padding:8px 0; padding-left:5px;"> <a href="flow.php" class="continue_buy" style="padding:0;">返回修改购物车</a> </div>
      <div style="float:right;width:55%;text-align:right;padding:8px 20px;"> 
        
        <input onclick="return check_before_submit()" type="image" src="themes/68ecshopcom_360buy/images/jmpic/btn_done.gif" align="absmiddle" />
        
        <input name="need_inv" style="display:none;" type="checkbox"  class="input" id="ECS_NEEDINV" onclick="changeNeedInv()" value="1" checked="true" />
        <input type="hidden" name="step" value="done" />
        <input type="hidden" name="have_consignee" value="<?php if ($this->_var['consignee_list']): ?>1<?php else: ?>0<?php endif; ?>" />
      </div>
    </div>
    <div class="blank10"></div>
  </form>
  <script>
  
    if(document.getElementById('shipping_<?php echo $this->_var['order']['shipping_id']; ?>')){
	document.getElementById('shipping_<?php echo $this->_var['order']['shipping_id']; ?>').click();
    }
    </script> 
  <?php endif; ?> 
  
  <?php if ($this->_var['step'] == "done"): ?> 
  
  <div id="A_Stepbar" class="flowstep">
    <ol class="flowstep-5">
      <li class="step-first">
        <div class="step-done">
          <div class="step-name">查看购物车</div>
          <div class="step-no"></div>
        </div>
      </li>
      <li>
        <div class="step-done">
          <div class="step-name">拍下商品</div>
          <div class="step-no"></div>
        </div>
      </li>
      <li>
        <div class="step-done">
          <div class="step-name">付款</div>
          <div class="step-no"></div>
        </div>
      </li>
      <li>
        <div class="step-name">确认收货</div>
        <div class="step-no">4</div>
      </li>
      <li class="step-last">
        <div class="step-name">评价</div>
        <div class="step-no">5</div>
      </li>
    </ol>
  </div>
  <div class="flowBox" style="margin:30px auto 70px auto;">
    <h6 style="text-align:center; height:30px; line-height:30px;"><?php echo $this->_var['lang']['remember_order_number']; ?>: <font style="color:red"><?php echo $this->_var['order']['order_sn']; ?></font></h6>
    <table width="99%" align="center" border="0" cellpadding="15" cellspacing="0" bgcolor="#fff" style="border:1px solid #ddd; margin:20px auto;" >
      <tr>
        <td align="center" bgcolor="#FFFFFF"><?php if ($this->_var['order']['shipping_name']): ?><?php echo $this->_var['lang']['select_shipping']; ?>: <strong><?php echo $this->_var['order']['shipping_name']; ?></strong>，<?php endif; ?><?php echo $this->_var['lang']['select_payment']; ?>: <strong><?php echo $this->_var['order']['pay_name']; ?></strong>。<?php echo $this->_var['lang']['order_amount']; ?>: <strong><?php echo $this->_var['total']['amount_formated']; ?></strong></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['order']['pay_desc']; ?></td>
      </tr>
      <?php if ($this->_var['pay_online']): ?> 
      
      <tr>
        <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['pay_online']; ?></td>
      </tr>
      <?php endif; ?>
    </table>
    <?php if ($this->_var['virtual_card']): ?>
    <div style="text-align:center;overflow:hidden;border:1px solid #E2C822;background:#FFF9D7;margin:10px;padding:10px 50px 30px;"> 
      <?php $_from = $this->_var['virtual_card']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vgoods');if (count($_from)):
    foreach ($_from AS $this->_var['vgoods']):
?>
      <h3 style="color:#2359B1; font-size:12px;"><?php echo $this->_var['vgoods']['goods_name']; ?></h3>
      <?php $_from = $this->_var['vgoods']['info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'card');if (count($_from)):
    foreach ($_from AS $this->_var['card']):
?>
      <ul style="list-style:none;padding:0;margin:0;clear:both">
        <?php if ($this->_var['card']['card_sn']): ?>
        <li style="margin-right:50px;float:left;"> <strong><?php echo $this->_var['lang']['card_sn']; ?>:</strong><span style="color:red;"><?php echo $this->_var['card']['card_sn']; ?></span> </li>
        <?php endif; ?> 
        <?php if ($this->_var['card']['card_password']): ?>
        <li style="margin-right:50px;float:left;"> <strong><?php echo $this->_var['lang']['card_password']; ?>:</strong><span style="color:red;"><?php echo $this->_var['card']['card_password']; ?></span> </li>
        <?php endif; ?> 
        <?php if ($this->_var['card']['end_date']): ?>
        <li style="float:left;"> <strong><?php echo $this->_var['lang']['end_date']; ?>:</strong><?php echo $this->_var['card']['end_date']; ?> </li>
        <?php endif; ?>
      </ul>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    </div>
    <?php endif; ?>
    <p style="text-align:center; margin-bottom:20px;"><?php echo $this->_var['order_submit_back']; ?></p>
  </div>
  <?php endif; ?> 
  <?php if ($this->_var['step'] == "login"): ?> 
  <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,user.js')); ?> 
  <script type="text/javascript">
        <?php $_from = $this->_var['lang']['flow_login_register']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
          var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

        
        function checkLoginForm(frm) {
          if (Utils.isEmpty(frm.elements['username'].value)) {
            alert(username_not_null);
            return false;
          }

          if (Utils.isEmpty(frm.elements['password'].value)) {
            alert(password_not_null);
            return false;
          }

          return true;
        }

        function checkSignupForm(frm) {
          if (Utils.isEmpty(frm.elements['username'].value)) {
            alert(username_not_null);
            return false;
          }

          if (Utils.trim(frm.elements['username'].value).match(/^\s*$|^c:\\con\\con$|[%,\'\*\"\s\t\<\>\&\\]/))
          {
            alert(username_invalid);
            return false;
          }

          if (Utils.isEmpty(frm.elements['email'].value)) {
            alert(email_not_null);
            return false;
          }

          if (!Utils.isEmail(frm.elements['email'].value)) {
            alert(email_invalid);
            return false;
          }

          if (Utils.isEmpty(frm.elements['password'].value)) {
            alert(password_not_null);
            return false;
          }

          if (frm.elements['password'].value.length < 6) {
            alert(password_lt_six);
            return false;
          }

          if (frm.elements['password'].value != frm.elements['confirm_password'].value) {
            alert(password_not_same);
            return false;
          }
          return true;
        }
        
        </script> 
  
  <div class="flowBox">
    <table width="99%" align="center" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
      <tr>
        <td width="50%" valign="top" bgcolor="#ffffff"><h6><span>用户登录：</span></h6>
          <form action="flow.php?step=login" method="post" name="loginForm" id="loginForm" onsubmit="return checkLoginForm(this)">
            <table width="90%" border="0" cellpadding="8" cellspacing="1" bgcolor="#B0D8FF" class="table">
              <tr>
                <td bgcolor="#ffffff"><div align="right"><strong><?php echo $this->_var['lang']['username']; ?></strong></div></td>
                <td bgcolor="#ffffff"><input name="username" type="text" class="inputBg" id="username" /></td>
              </tr>
              <tr>
                <td bgcolor="#ffffff"><div align="right"><strong><?php echo $this->_var['lang']['password']; ?></strong></div></td>
                <td bgcolor="#ffffff"><input name="password" class="inputBg" type="password" /></td>
              </tr>
              <?php if ($this->_var['enabled_login_captcha']): ?>
              <tr>
                <td bgcolor="#ffffff"><div align="right"><strong><?php echo $this->_var['lang']['comment_captcha']; ?>:</strong></div></td>
                <td bgcolor="#ffffff"><input type="text" size="8" name="captcha" class="inputBg" />
                  <img src="captcha.php?is_login=1&<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?is_login=1&'+Math.random()" /></td>
              </tr>
              <?php endif; ?>
              <tr>
                <td colspan="2"  bgcolor="#ffffff"><input type="checkbox" value="1" name="remember" id="remember" />
                  <label for="remember"><?php echo $this->_var['lang']['remember']; ?></label></td>
              </tr>
              <tr>
                <td bgcolor="#ffffff" colspan="2" align="center"><a href="user.php?act=qpassword_name" class="f6"><?php echo $this->_var['lang']['get_password_by_question']; ?></a>&nbsp;&nbsp;&nbsp;<a href="user.php?act=get_password" class="f6"><?php echo $this->_var['lang']['get_password_by_mail']; ?></a></td>
              </tr>
              <tr>
                <td bgcolor="#ffffff" colspan="2"><div align="center">
                    <input type="submit" class="bnt_blue" name="login" value="<?php echo $this->_var['lang']['forthwith_login']; ?>" />
                    <?php if ($this->_var['anonymous_buy'] == 1): ?>
                    <input type="button" class="bnt_blue_2" value="<?php echo $this->_var['lang']['direct_shopping']; ?>" onclick="location.href='flow.php?step=consignee&amp;direct_shopping=1'" />
                    <?php endif; ?>
                    <input name="act" type="hidden" value="signin" />
                  </div></td>
              </tr>
            </table>
          </form></td>
        <td valign="top" bgcolor="#ffffff"><h6><span>用户注册：</span></h6>
          <form action="flow.php?step=login" method="post" name="formUser" id="registerForm" onsubmit="return checkSignupForm(this)">
            <table width="98%" border="0" cellpadding="8" cellspacing="1" bgcolor="#B0D8FF" class="table">
              <tr>
                <td bgcolor="#ffffff" align="right" width="25%"><strong><?php echo $this->_var['lang']['username']; ?></strong></td>
                <td bgcolor="#ffffff"><input name="username" type="text" class="inputBg" id="username" onblur="is_registered(this.value);" />
                  <br />
                  <span id="username_notice" style="color:#FF0000"></span></td>
              </tr>
              <tr>
                <td bgcolor="#ffffff" align="right"><strong><?php echo $this->_var['lang']['email_address']; ?></strong></td>
                <td bgcolor="#ffffff"><input name="email" type="text" class="inputBg" id="email" onblur="checkEmail(this.value);" />
                  <br />
                  <span id="email_notice" style="color:#FF0000"></span></td>
              </tr>
              <tr>
                <td bgcolor="#ffffff" align="right"><strong><?php echo $this->_var['lang']['password']; ?></strong></td>
                <td bgcolor="#ffffff"><input name="password" class="inputBg" type="password" id="password1" onblur="check_password(this.value);" onkeyup="checkIntensity(this.value)" />
                  <br />
                  <span style="color:#FF0000" id="password_notice"></span></td>
              </tr>
              <tr>
                <td bgcolor="#ffffff" align="right"><strong><?php echo $this->_var['lang']['confirm_password']; ?></strong></td>
                <td bgcolor="#ffffff"><input name="confirm_password" class="inputBg" type="password" id="confirm_password" onblur="check_conform_password(this.value);" />
                  <br />
                  <span style="color:#FF0000" id="conform_password_notice"></span></td>
              </tr>
              <?php if ($this->_var['enabled_register_captcha']): ?>
              <tr>
                <td bgcolor="#ffffff" align="right"><strong><?php echo $this->_var['lang']['comment_captcha']; ?>:</strong></td>
                <td bgcolor="#ffffff"><input type="text" size="8" name="captcha" class="inputBg" />
                  <img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?'+Math.random()" /></td>
              </tr>
              <?php endif; ?>
              <tr>
                <td colspan="2" bgcolor="#ffffff" align="center"><input type="submit" name="Submit" class="bnt_blue_1" value="<?php echo $this->_var['lang']['forthwith_register']; ?>" />
                  <input name="act" type="hidden" value="signup" /></td>
              </tr>
            </table>
          </form></td>
      </tr>
      <?php if ($this->_var['need_rechoose_gift']): ?>
      <tr>
        <td colspan="2" align="center" style="border-top:1px #ccc solid; padding:5px; color:red;"><?php echo $this->_var['lang']['gift_remainder']; ?></td>
      </tr>
      <?php endif; ?>
    </table>
  </div>
   
  <?php endif; ?> 
  
</div>
</div>
<?php echo $this->fetch('library/page_footer.lbi'); ?> <?php echo $this->fetch('library/site_bar.lbi'); ?>
</body>
<div id="pop" class="pop" style="display:none">
  					<div class="pop_head">选择自提点</div>
                    <a href="javascript:void(0);" onclick="hide('pop')" title="关闭"  class="pop_head_r"></a>
  					<div class="pop_body" id='pickcontent'></div>
				</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'order_pickpoint.js')); ?>
<div class="choose" id="choose" style="display:none"></div>
<script type="text/javascript">
function closeCustomer(){
	$("#choose").hide();
	}
function choose_gift(suppid)
{
	var sel_goods = new Array();
	var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
	var j = 0;
	for (i=0;i<obj_cartgoods.length;i++)
	{
		if(obj_cartgoods[i].checked == true)
		{	
			sel_goods[j] = obj_cartgoods[i].value;
			j++;
		}
	}
	Ajax.call('flow.php', 'is_ajax=1&suppid=' + suppid + '&sel_goods='+sel_goods, selgiftResponse, 'GET', 'JSON');
}
function selgiftResponse(res)
{
	$('#choose').html(res.result).show();
}
</script>
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
<?php $_from = $this->_var['lang']['passport_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var username_exist = "<?php echo $this->_var['lang']['username_exist']; ?>";
var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
</script>
</html>
