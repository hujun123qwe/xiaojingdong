<?php

/**
 * ECSHOP 列出所有分类及品牌
 * ============================================================================
 * * 版权所有 2008-2015 秦皇岛商之翼网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.68ecshop.com;
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: derek $
 * $Id: catalog.php 17217 2011-01-19 06:29:08Z derek $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

if (!$smarty->is_cached('article_cat_list.dwt'))
{
     /* 如果页面没有被缓存则重新获得页面的内容 */

    assign_template('a', array($cat_id));
    $position = assign_ur_here($cat_id);
    $smarty->assign('page_title',           $position['title']);     // 页面标题
    $smarty->assign('ur_here',              $position['ur_here']);   // 当前位置


    $smarty->assign('article_categories',   article_categories_tree($cat_id)); //文章分类树

    $meta = $db->getRow("SELECT keywords, cat_desc FROM " . $ecs->table('ecsmart_article_cat') . " WHERE cat_id = '$cat_id'");
    $smarty->assign('keywords',    htmlspecialchars($meta['keywords']));
    $smarty->assign('description', htmlspecialchars($meta['cat_desc']));

}
$smarty->display('article_cat_list.dwt');
