<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://xjd.local/" />
<meta name="Generator" content="68ECSHOP v4_2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $this->_var['page_title']; ?></title>



<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,transport.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery-1.6.2.min.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>
<link rel="Stylesheet" type="text/css" href="themes/68ecshopcom_360buy/css/catalog.css" />
</head>
<body>
<div id="site-nav"> <?php echo $this->fetch('library/page_header.lbi'); ?>
  <div class="blank"></div>
  <div class="w">
    <ul class="tab" id="tab-link">
      <li class="curr"><a href="catalog.php">全部商品分类</a></li>
      <li><a href="brand.php">全部品牌</a></li>
      <li><a href="search.php">全部商品</a></li>
    </ul>
     
  </div>
  <?php
	  $GLOBALS['smarty']->assign('categories',       get_categories_tree(0)); // 分类树
	  ?>
  <div class="w" id="tab-sort">
    <div class="i-w">
      <div class="text">更多特价产品，请进入以下二级频道页面</div>
      <ul class="tab">
        <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['categories'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categories']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['categories']['iteration']++;
?>
        <li><a href="<?php echo $this->_var['cat']['url']; ?>"><?php echo htmlspecialchars($this->_var['cat']['name']); ?></a></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
    </div>
  </div>
  <div class="w" id="allsort">
    <div class="fl"> 
      <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['categories'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categories']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['categories']['iteration']++;
?> 
      <?php if ($this->_foreach['categories']['iteration'] % 2 == 1): ?>
      <div class="m">
        <div class="mt">
          <h2><a href="<?php echo $this->_var['cat']['url']; ?>"><?php echo htmlspecialchars($this->_var['cat']['name']); ?></a></h2>
        </div>
        <div class="mc"> 
          <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['cat_cat_id'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat_cat_id']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['cat_cat_id']['iteration']++;
?> 
          <dl 
        <?php if ($this->_foreach['cat_cat_id']['iteration'] == 1): ?> 
          class="fore" 
          <?php endif; ?> 
          >
          <dt><a href="<?php echo $this->_var['child']['url']; ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a></dt>
          <dd> 
            <?php $_from = $this->_var['child']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');if (count($_from)):
    foreach ($_from AS $this->_var['childer']):
?> 
            <em><a href="<?php echo $this->_var['childer']['url']; ?>"><?php echo htmlspecialchars($this->_var['childer']['name']); ?></a></em> 
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
          </dd>
          </dl>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        </div>
      </div>
      <?php endif; ?> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    </div>
    
    <div class="fr"> 
      <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['categories'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categories']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['categories']['iteration']++;
?> 
      <?php if ($this->_foreach['categories']['iteration'] % 2 == 0): ?>
      <div class="m">
        <div class="mt">
          <h2><a href="<?php echo $this->_var['cat']['url']; ?>"><?php echo htmlspecialchars($this->_var['cat']['name']); ?></a></h2>
        </div>
        <div class="mc"> 
          <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['cat_cat_id'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat_cat_id']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['cat_cat_id']['iteration']++;
?> 
          <dl 
        <?php if ($this->_foreach['cat_cat_id']['iteration'] == 1): ?> 
          class="fore" 
          <?php endif; ?> 
          >
          <dt><a href="<?php echo $this->_var['child']['url']; ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a></dt>
          <dd> 
            <?php $_from = $this->_var['child']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');if (count($_from)):
    foreach ($_from AS $this->_var['childer']):
?> 
            <em><a href="<?php echo $this->_var['childer']['url']; ?>"><?php echo htmlspecialchars($this->_var['childer']['name']); ?></a></em> 
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
          </dd>
          </dl>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        </div>
      </div>
      <?php endif; ?> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    </div>
     
  </div>
  <div style="height:0px;line-height:0px;clear:both"></div>
  <?php echo $this->fetch('library/help.lbi'); ?> <?php echo $this->fetch('library/page_footer.lbi'); ?> </div>
</body>
</html>
