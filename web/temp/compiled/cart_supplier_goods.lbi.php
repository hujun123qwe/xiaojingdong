<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'cartgoods');$this->_foreach['gl'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gl']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['cartgoods']):
        $this->_foreach['gl']['iteration']++;
?>
<table  align="center"  cellpadding="0" cellspacing="0" style="height:auto;width:100%;">
<tr height="35">
  <td style="border-top:2px solid #d9d9d9; text-indent:19px; background:#FAFAFA;font-weight:bold;color:#FF0000"><?php echo $this->_var['cartgoods']['supplier_name']; ?><input type="hidden" name="supplierid" id="supplierid" value="<?php echo $this->_var['key']; ?>"></td>
</tr>
</table>
<table  align="center"  cellpadding="0" cellspacing="0" style="height:auto;width:100%;">
<?php $_from = $this->_var['cartgoods']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods_list']['iteration']++;
?>
<tr>
  <td style="width:100%;<?php if (! ($this->_foreach['goods_list']['iteration'] == $this->_foreach['goods_list']['total'])): ?>border-bottom:1px dashed #ddd;<?php endif; ?>"><table cellpadding="5" cellspacing="1" border=0 width="100%" <?php if (! $this->_var['goods']['is_cansel']): ?>style="background:#ddd;"<?php endif; ?>>
      <tr > 
	<td  align="center"  width="5%"><input type="checkbox" autocomplete="off" name="sel_cartgoods[]" value="<?php echo $this->_var['goods']['rec_id']; ?>" id="sel_cartgoods_<?php echo $this->_var['goods']['rec_id']; ?>" checked=checked onclick="select_cart_goods();"></td>
	
	<td  align="center"  width="40%">
    <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?>
	  
	  <div class="thumb_name">
	    <dl >
	      <dt> <a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" border="0" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" /></a> </dt>
	      <dd> <a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank" class="f6"><?php echo $this->_var['goods']['goods_name']; ?></a> 
		<?php if ($this->_var['show_goods_attribute'] == 1): ?><br>
		<font class="attrname"><?php echo nl2br($this->_var['goods']['goods_attr']); ?></font><?php endif; ?> 
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
		  <div id="suit_<?php echo $this->_var['goods']['goods_id']; ?>" style="float:left;position:absolute;background:#fff;width:500px;top:25px;left:0;border:1px solid #31c8e3;padding:10px 0;display:none; z-index:99;">
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
	<td align=center  width="15%"><?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['is_gift'] == 0 && $this->_var['goods']['parent_id'] == 0): ?>
	  
	  <div class="jm_cartnum"> <span class="jmminu" <?php if ($this->_var['goods']['is_cansel']): ?>onclick="minus_num(<?php echo $this->_var['goods']['rec_id']; ?>,<?php echo $this->_var['goods']['goods_id']; ?>,<?php echo $this->_var['key']; ?>,<?php if ($this->_var['goods']['extension_code'] == 'package_buy'): ?>1<?php else: ?>0<?php endif; ?>);"<?php endif; ?>>-</span>
	    <input type="text" name="goods_number[<?php echo $this->_var['goods']['rec_id']; ?>]" id="goods_number_<?php echo $this->_var['goods']['rec_id']; ?>" value="<?php echo $this->_var['goods']['goods_number']; ?>" size="4" class="jminputBg"   onKeyDown='if(event.keyCode == 13) event.returnValue = false'  onblur="change_price(<?php echo $this->_var['goods']['rec_id']; ?>,<?php echo $this->_var['goods']['goods_id']; ?>,<?php if ($this->_var['goods']['extension_code'] == 'package_buy'): ?>1<?php else: ?>0<?php endif; ?>)" />
	    <input type="hidden" id="hidden_<?php echo $this->_var['goods']['rec_id']; ?>" value="<?php echo $this->_var['goods']['goods_number']; ?>">
	    <span class="jmadd" <?php if ($this->_var['goods']['is_cansel']): ?>onclick='javascript:add_num(<?php echo $this->_var['goods']['rec_id']; ?>,<?php echo $this->_var['goods']['goods_id']; ?>,<?php echo $this->_var['key']; ?>,<?php if ($this->_var['goods']['extension_code'] == 'package_buy'): ?>1<?php else: ?>0<?php endif; ?>)' <?php endif; ?>>+</span> </div>
	  
	  <?php else: ?> 
	  <?php echo $this->_var['goods']['goods_number']; ?> 
	  <?php endif; ?></td>
	<td align="center"  width="15%"><font class="cart_jmprice" id="goods_price_<?php echo $this->_var['goods']['rec_id']; ?>"><?php echo $this->_var['goods']['goods_price']; ?></font></td>
	<td align="center"  width="15%"><font class="cart_jmprice" id="subtotal_<?php echo $this->_var['goods']['rec_id']; ?>"><?php echo $this->_var['goods']['subtotal']; ?></font></td>
	<td align="center"  width="10%"><a href="javascript:if (confirm('<?php echo $this->_var['lang']['drop_goods_confirm']; ?>')) location.href='flow.php?step=drop_goods&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>'; " class="f6"><?php echo $this->_var['lang']['drop']; ?></a></td>
      </tr>
    </table></td>
</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<?php if ($this->_var['cartgoods']['favourable'] || $this->_var['cartgoods']['discount']): ?>
<table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" bgcolor="#ffffff" style="border-top:1px dashed #ddd; margin-bottom:10px;">
<tr>
  <td bgcolor="#ffffff" align=right style="padding:10px 15px 0 0;"><?php if ($this->_var['cartgoods']['favourable']): ?> <a class="choose_gift" href="javascript:void(0);" onclick="choose_gift(<?php echo $this->_var['key']; ?>)"><b class="gift_68"></b>选择赠品</a><?php endif; ?> 
    <span id="zk_<?php echo $this->_var['key']; ?>"><?php if ($this->_var['cartgoods']['discount']): ?><?php echo $this->_var['cartgoods']['discount']['your_discount']; ?><?php endif; ?></span></td>
</tr>
</table>
<?php endif; ?> 
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>