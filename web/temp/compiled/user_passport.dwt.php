<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://xjd.local/" />
<meta name="Generator" content="68ECSHOP v4_2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link rel="stylesheet" type="text/css" href="themes/68ecshopcom_360buy/css/68ecshop_commin.css" />
<link type="text/css" rel="stylesheet" href="themes/68ecshopcom_360buy/css/passport.css"/>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery_email.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.9.1.min.js" ></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/placeholder.js" ></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/user.js" ></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,user.js')); ?>
</head>
<body onclick="ecshop68_onclick();">
<script>
function erweima1(obj, sType) { var oDiv = document.getElementById(obj); if (sType == 'show') {oDiv.style.display = 'block';} if (sType == 'hide') {oDiv.style.display = 'none';} }
</script>
<div class="Logo-r">
  <div class="Logo-info-r"> 
  	<a href="./" class="logo"></a>
    <span class="findpw">欢迎登录</span>
	<?php echo $this->fetch('library/user_right.lbi'); ?>
  </div>
</div>
  <div class="blank"></div>
  <div class="blank"></div>
  <div class="w"> 
    
     
    <?php if ($this->_var['action'] == 'login'): ?>
    
    <div class="w" id="entry">
    <div class="mcon">
      <div id="reg-pic" class="box-pic"></div>
      <div id="login-box" class="uc_box">
        <form name="formLogin" action="user.php?XDEBUG_SESSION_START=ECLIPSE_DBGP" method="post" onSubmit="return userLogin()">
          <h2><span>还没有账号？<a href="register.php">立即注册</a></span></h2>
          <div class="form">
          
            <div class="item"> <span class="label">账户名</span>
      
                <input type="text" id="username" name="username" class="text" tabindex="1" placeholder="手机号/用户名/邮箱"/>
  
            </div>
            <div class="item"> <span class="label">密码</span>
          
                <input type="password" id="password" name="password" class="text" tabindex="2"/>
         
            </div>
            <?php if ($this->_var['enabled_captcha']): ?>
            <div class="item " id="o-authcode"> <span class="label">验证码</span>
              <div>
                <input type="text" id="authcode" name="captcha" class="text text-1" tabindex="3"/>
                <label class="img"> <img src="captcha.php?is_login=1&<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?is_login=1&'+Math.random()" /> </label>
              </div>
            </div>
            <?php endif; ?>
            <div class="item" id="autoentry">
              <div class="safety">
                <input type="checkbox" value="1" name="remember" id="remember" class="checkbox"/>
                <label for="remember" class="mar-b"><?php echo $this->_var['lang']['remember']; ?></label>
                <!-- 
                <a class="forget_password" href="user.php?act=forget_password">忘记密码？</a>
                 -->
                <a class="forget_password" href="findPwd.php" style="color:#E4393C">忘记密码？</a>
            </div>
            </div>
            <div class="item">
              <input type="hidden" name="act" value="act_login" />
              <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
              <input type="submit" name="submit" class="btn-img btn-entry" id="loginsubmit" value="立即登录" />
            </div>
            <div class="blank"></div>
            <div class="item">
              <table width="300" border="0" cellpadding="5" cellspacing="0">
                <tr>
		          <td><a style="text-decoration:none" href="user.php?act=oath&type=weixin"><i class="weixin"></i>&nbsp;&nbsp;微信</a></td>
                  <td><a style="text-decoration:none" href="user.php?act=oath&type=qq"><i class="qq"></i>&nbsp;&nbsp;QQ</a></td>
                  <td><a style="text-decoration:none" href="user.php?act=oath&type=weibo"><i class="sina"></i>&nbsp;&nbsp;新浪</a></td>
                  <td><a style="text-decoration:none" href="user.php?act=oath&type=alipay"><i class="alipay"></i>&nbsp;&nbsp;支付宝</a></td>
                </tr>
              </table>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
    <?php endif; ?> 
     
    
     
    <?php if ($this->_var['action'] == 'register'): ?> 
    <?php if ($this->_var['shop_reg_closed'] == 1): ?>
    
    <div class="usBox">
      <div class="usBox_2 clearfix">
        <div class="f1 f5" align="center"><?php echo $this->_var['lang']['shop_register_closed']; ?></div>
      </div>
    </div>
    <?php else: ?> 
    <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
    <div class="w" id="regist">
      <div class="mcon">
      <div id="reg-pic" class="box-pic box-pic1"></div>
      <div id="login-box" class="uc_box"> 
         
        <script>var mobile_field=''; var mobile_field_sms='';</script>
        <form action="user.php" method="post" name="formUser" onsubmit="return register2();">
          <div class="form">
	  <h2><strong>欢迎注册</strong><span>已有账号！<a href="user.php?act=login">立即登录</a></span></h2>
            <div class="item">
              <input name="username" type="text" id="username" placeholder="<?php echo $this->_var['lang']['label_username']; ?>" onblur="is_registered(this.value);" class="text" >
              <i class="i-name"></i>
              <div><span class="label" id="username_notice"></span></div>
            </div>
            <div id="o-password">
              <div class="item">
                  <input name="password" type="password" id="password1" placeholder="<?php echo $this->_var['lang']['label_password']; ?>" onblur="check_password(this.value);" onkeyup="checkIntensity(this.value)" class="text" />
                  <i class="i-pass"></i>
                <div><span class="label" id="password_notice"></span>
                  <table width="290" border="0" cellspacing="0" cellpadding="0" style="padding:0px 0px 10px; display:none">
                    <tr align="center">
                      <td width="33%" id="pwd_lower"><?php echo $this->_var['lang']['pwd_lower']; ?></td>
                      <td width="33%" id="pwd_middle"><?php echo $this->_var['lang']['pwd_middle']; ?></td>
                      <td width="33%" id="pwd_high"><?php echo $this->_var['lang']['pwd_high']; ?></td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="item">
                <input type="password" id="conform_password" name="confirm_password" class="text" placeholder="<?php echo $this->_var['lang']['label_confirm_password']; ?>"  onblur="check_conform_password(this.value);" autocomplete="off"/>
                <i class="i-pass"></i>
                <div><span class="label" id="conform_password_notice"></span></div>
              </div>
            </div>
			<div class="item">
                <input name="email" type="text" id="email" placeholder="<?php echo $this->_var['lang']['label_email']; ?>" onblur="checkEmail(this.value);" class="text" />
                <i class="i-email"></i>
              <div><span class="label" id="email_notice" ></span><a href="javascript:ck_email()" style="color:blue;height:36px;line-height:36px">验证邮箱</a> </div>
                
            </div>
            <?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?> 
            <?php if ($this->_var['field']['id'] == 6): ?>
            <div class="item">
              <select name='sel_question' style="width:247px;height:36px;line-height:36px;">
                <option value='0'><?php echo $this->_var['lang']['sel_question']; ?></option>
                
                  
	  <?php echo $this->html_options(array('options'=>$this->_var['passwd_questions'])); ?>
	  
                
              </select>
            </div>
            <div class="item" style="margin-top:30px;*margin-top:15px;">
              <input name="passwd_answer" type="text" class="text" placeholder="<?php echo $this->_var['lang']['passwd_answer']; ?>"/>
              <i class="i-pass"></i>
              <div><span class="label" <?php if ($this->_var['field']['is_need']): ?>id="passwd_quesetion"<?php endif; ?>></span></div>
            </div>            
            <?php else: ?>
            <div class="item">
              <input name="extend_field<?php echo $this->_var['field']['id']; ?>" id="extend_field<?php echo $this->_var['field']['id']; ?>" type="text" class="text" placeholder="<?php echo $this->_var['field']['reg_field_name']; ?>"/>
              <i class="<?php if ($this->_var['field']['id'] == 1): ?>i-msn<?php elseif ($this->_var['field']['id'] == 2): ?>i-qq<?php elseif ($this->_var['field']['id'] == 3): ?>i-bgphone<?php elseif ($this->_var['field']['id'] == 4): ?>i-jtphone<?php elseif ($this->_var['field']['id'] == 5): ?>i-phone<?php else: ?>i-phone<?php endif; ?>"></i>
              <div><span class="label" <?php if ($this->_var['field']['is_need']): ?>id="extend_field<?php echo $this->_var['field']['id']; ?>i"<?php endif; ?>></span></div>
            </div>
            
            <?php if ($this->_var['field']['reg_field_name'] == '验证手机'): ?> 
            <script>mobile_field='extend_field<?php echo $this->_var['field']['id']; ?>';</script> 
            <?php if ($this->_var['sms_register'] == '1'): ?>
            <div class="item" style="margin-bottom:30px;">
              <input name="mobile_code" id="mobile_code" type="text" class="text text_te" placeholder="手机验证码">
              <i class="i-phone"></i> 
                <?php if ($this->_var['field']['reg_field_name'] == '验证手机' && $this->_var['sms_register'] == '1'): ?>
                <input id="zphone" type="button" value=" 获取手机验证码 " onclick="sendSms();" class="zphone">
                <?php endif; ?> 
              <div><span class="label" <?php if ($this->_var['field']['is_need']): ?>id="extend_field<?php echo $this->_var['field']['id']; ?>i"<?php endif; ?>></span></div>
            </div>
            <script>mobile_field_sms='1';</script> 
            <?php endif; ?> 
            <?php endif; ?> 
            <script type="text/javascript" src="sms/sms.js"></script> 

            <?php endif; ?> 
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
            
            <?php if ($this->_var['enabled_captcha']): ?>
            <div class="item">
              <input type="text" id="authcode" size="8" name="captcha" class="text text_te" placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" style="ime-mode:disabled"  autocomplete="off" MaxLength="6"/>
              <label class="img" style="margin-left:5px;margin-top:2px"> <img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?'+Math.random()" /> </label>
            </div>
            <?php endif; ?>
            <div class="item item_t">
              <div class="safety">
                <input name="agreement" type="checkbox" value="1" checked="checked" class="checkbox"/>
                <label for="remember" class="mar-b"><?php echo $this->_var['lang']['agreement']; ?></label>
              </div>
            </div>
       		<div class="item">
              <input name="act" type="hidden" value="act_register" >
              <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
              <input name="Submit" type="submit" class="btn-img btn-regist" id="registsubmit" value="立即注册" />
            </div>
        </div>
      </form>
        <!--[if !ie]>form end<![endif]--> 
         
      </div>
    </div>
    </div>
     
    <script type="text/javascript">
function ck_email()
{
	 var email = document.getElementById('email').value;
	 if(email == '')
	 {
		 document.getElementById('email_notice').innerHTML = '邮箱不能为空！';
	 }
	 else
	 {
		 if ( ! (Utils.isEmail(email)))
    	{
			document.getElementById('email_notice').innerHTML = '邮箱格式不正确！';
    	}
		else
		{
			Ajax.call('user.php?act=ch_email&email=' + email,'', chemailResponse, 'GET', 'JSON',true,true);
			/*Ajax.call('user.php?act=ch_email&email=' + email, '', chemailResponse, 'GET', 'JSON',true,true);*/
		}
	 }	 
}

function chemailResponse(result)
{
	alert(result.message);
}
</script> 
     
    <?php endif; ?> 
    <?php endif; ?> 
     
     
    <?php if ($this->_var['action'] == 'forget_password'): ?> 
    <?php echo $this->smarty_insert_scripts(array('files'=>'sms.js')); ?>
    <div id="entry1">
    <div class="mcon">
      <div id="reg-pic" class="box-pic box-pic2"></div>
      <div id="login-box" class="uc_box">
        <form action="user.php" method="post" name="fpForm" onsubmit="return forget_pass();">
          <div class="form">
            <h2><strong>找回密码</strong></h2>
            <div class="item">
              <input name="u_name" id="u_name" type="text" class="text" tabindex="1" value="<?php echo $this->_var['lang']['label_username']; ?>" onfocus="if(this.value=='<?php echo $this->_var['lang']['label_username']; ?>') this.value=''" onblur="if(this.value=='') this.value='<?php echo $this->_var['lang']['label_username']; ?>'" />
              <div><span class="label"></span></div>
            </div>
            <div class="item">
              <div class="select-outer select-wh200"  style="margin-bottom:20px;">
                <div class="select-inner">
                  <select name="find_type" id="find_type" onchange="choose_type(this.value);">
                    <option value="0">请选择找回密码方式</option>
                    <option value="1">手机号找回密码</option>
                    <option value="2">邮箱找回密码</option>
                    
                  </select>
                  <span class="clr"></span> </div>
              </div>
            </div>
            <div class="item" id="f_mobile" style="display:none">
              <input type="text" name="mobile" id="mobile" class="text" value="手机号"  onfocus="if(this.value=='手机号') this.value=''" onblur="if(this.value=='') this.value='手机号'" />
              <div><span class="label"></span></div>
            </div>
            <div class="item" id="f_code" style="display:none;margin-bottom:20px;">
              <input type="text" name="code" id="code" class="text text1" value="验证码"  onfocus="if(this.value=='验证码') this.value=''" onblur="if(this.value=='') this.value='验证码'" />
                <input id="fphone" type="button" value="获取手机验证码" onclick="getverifycode3();">
              <div><span class="label"></span></div>
            </div>
            <div class="item" id="f_email" style="display:none">
              <input type="text" name="email" id="email" class="text" value="邮箱"  onfocus="if(this.value=='邮箱') this.value=''" onblur="if(this.value=='') this.value='邮箱'" />
              <div><span class="label"></span></div>
            </div>
            <div class="item"> 
              <input type="submit" name="submit" class="btn-img btn-regist" value="提交"  />
              <input type="hidden" name="act" value="act_forget_pass" />
            </div>
          </div>
        </form>
      </div>
    </div>
    </div>
    <?php endif; ?> 
    
    <?php if ($this->_var['action'] == 're_pass'): ?> 
    <script type="text/javascript">
    <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
    <div id="entry1">
    <div class="mcon">
      <div id="reg-pic" class="box-pic box-pic2"></div>
      <div id="login-box" class="uc_box">
        <form action="user.php" method="post" name="getPassword2" onSubmit="return submitPwd()">
          <div class="form">
            <h2><strong>重置密码</strong></h2>
            <div class="item">
              <input id="new_password" name="new_password" type="password" class="text" tabindex="1" value="<?php echo $this->_var['lang']['new_password']; ?>" onfocus="if(this.value=='<?php echo $this->_var['lang']['new_password']; ?>') this.value=''" onblur="if(this.value=='') this.value='<?php echo $this->_var['lang']['new_password']; ?>'" />
              <div><span class="label"></span></div>
            </div>
            <div class="item">
              <input name="confirm_password" type="password" class="text" tabindex="1" value="<?php echo $this->_var['lang']['confirm_password']; ?>" onfocus="if(this.value=='<?php echo $this->_var['lang']['confirm_password']; ?>') this.value=''" onblur="if(this.value=='') this.value='<?php echo $this->_var['lang']['confirm_password']; ?>'" />
              <div><span class="label"></span></div>
            </div>
            <div class="item">
              <input type="hidden" name="act" value="act_edit_password" />
              <input type="hidden" name="uid" value="<?php echo $this->_var['uid']; ?>" />
              <input type="hidden" name="code" value="<?php echo $this->_var['code']; ?>" />
              <input type="submit" name="submit" class="btn-img btn-regist" value="提交" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
    <?php endif; ?> 
    
    
     
    <?php if ($this->_var['action'] == 'get_password'): ?> 
    <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?> 
    <script type="text/javascript">
    <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
    <div class="w" id="entry">
    <div class="mcon">
      <div id="reg-pic" class="box-pic box-pic2"></div>
      <div id="login-box" class="uc_box">
      	 <form action="user.php" method="post" name="getPassword" onsubmit="return submitPwdInfo();">
          <div class="form">
            <h2><strong>找回密码</strong></h2>
            <div class="item item_gqu"> <?php echo $this->_var['lang']['username_and_email']; ?></div>
            <div class="item"> 
              <span class="label"><?php echo $this->_var['lang']['username']; ?></span>
              <div>
                <input name="user_name" type="text" class="text" />
              </div>
            </div>
            <div class="item"> 
              <span class="label"><?php echo $this->_var['lang']['email']; ?></span>
              <div>
                <input name="email" type="text" class="text" />
              </div>
            </div>
             <div class="item item_qpass">
             	<input type="hidden" name="act" value="send_pwd_email" />
                <input type="submit" name="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="btn-entry" />
                <input name="button" type="button" onclick="history.back()" value="<?php echo $this->_var['lang']['back_page_up']; ?>" style="border:none;" class="btn-img" />
            </div>
           </div>
          </form>
      </div>
    </div>
    </div>
    <?php endif; ?> 
    
     
    <?php if ($this->_var['action'] == 'qpassword_name'): ?>
    <div class="w" id="entry">
    <div class="mcon">
      <div id="reg-pic" class="box-pic box-pic2"></div>
      <div id="login-box" class="uc_box">
      	<form action="user.php" method="post">
          <div class="form">
            <h2><strong>找回密码</strong></h2>
            <div class="item item_gqu"> <?php echo $this->_var['lang']['get_question_username']; ?></div>
            <div class="item"> 
              <span class="label">用户名：</span>
              <div>
                <input name="user_name" type="text" class="text" />
              </div>
            </div>
             <div class="item item_qpass">
              <input type="hidden" name="act" value="get_passwd_question" />
              <input type="submit" name="submit" class="btn-entry" value="<?php echo $this->_var['lang']['submit']; ?>" />
              <input name="button" type="button" onclick="history.back()" value="<?php echo $this->_var['lang']['back_page_up']; ?>" style="border:none;" class="btn-img" />
            </div>
           </div>
          </form>
      </div>
    </div>
    </div>
    <?php endif; ?> 
    
     
    <?php if ($this->_var['action'] == 'get_passwd_question'): ?>
    <div class="w" id="entry">
    <div class="mcon">
      <div id="reg-pic" class="box-pic box-pic2"></div>
      <div id="login-box" class="uc_box">
      	<form action="user.php" method="post">
          <div class="form">
            <h2><strong>找回密码</strong></h2>
            <div class="item item_gqu"> <?php echo $this->_var['lang']['input_answer']; ?></div>
            <div class="item"> 
              <span class="label"><?php echo $this->_var['lang']['passwd_question']; ?>：</span>
              <div>
                <?php echo $this->_var['passwd_question']; ?>
              </div>
            </div>
            <div class="item"> 
              <span class="label"><?php echo $this->_var['lang']['passwd_answer']; ?>：</span>
              <div>
                <input name="passwd_answer" type="text" class="text" />
              </div>
            </div>
            <div class="item">
              <span class="label"><?php echo $this->_var['lang']['comment_captcha']; ?>：</span>
              <div>
              	<input type="text" id="authcode" size="8" name="captcha" class="text text_te"  style="ime-mode:disabled"  autocomplete="off" MaxLength="6"/>
              	<label class="img" style="margin-left:5px"> <img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?'+Math.random()" /> </label>
              </div>
            </div>
             <div class="item item_qpass">
             	<input type="hidden" name="act" value="check_answer" />
                <input type="submit" name="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="btn-entry" />
                <input name="button" type="button" onclick="history.back()" value="<?php echo $this->_var['lang']['back_page_up']; ?>" style="border:none;" class="btn-img" />
            </div>
           </div>
          </form>
      </div>
    </div>
    </div>
    <?php endif; ?> 
    
    <?php if ($this->_var['action'] == 'reset_password'): ?> 
    <script type="text/javascript">
    <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
    <div class="w" id="entry">
    <div class="mcon">
      <div id="reg-pic" class="box-pic box-pic2"></div>
      <div id="login-box" class="uc_box">
      	<form action="user.php" method="post" name="getPassword2" onSubmit="return submitPwd()">
          <div class="form">
            <h2><strong>重置密码</strong></h2>
            <div class="item"> 
              <span class="label"><?php echo $this->_var['lang']['new_password']; ?></span>
              <div>
                <input id="new_password" name="new_password" type="password" class="text" />
              </div>
            </div>
             <div class="item"> 
              <span class="label"><?php echo $this->_var['lang']['confirm_password']; ?></span>
              <div>
                <input name="confirm_password" type="password" type="text" class="text" />
              </div>
            </div>
             <div class="item">
             	<input type="hidden" name="act" value="act_edit_password" />
                <input type="hidden" name="uid" value="<?php echo $this->_var['uid']; ?>" />
                <input type="hidden" name="code" value="<?php echo $this->_var['code']; ?>" />
                <input type="submit" name="submit" value="<?php echo $this->_var['lang']['confirm_submit']; ?>"  class="btn-img btn-entry"/>
            </div>
           </div>
          </form>
      </div>
    </div>
    </div>
    <?php endif; ?> 
    
    <script>
$(".mcon").height($(".uc_box").height());
</script>  
    <div class="blank"></div>
  </div>
  <?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
<?php $_from = $this->_var['lang']['passport_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var username_exist = "<?php echo $this->_var['lang']['username_exist']; ?>";
</script>
</html>
