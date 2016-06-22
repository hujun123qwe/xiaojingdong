<?php

/**
 * ECSHOP 用户评论管理程序
 * ============================================================================
 * 版权所有 2005-2011 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: comment_manage.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$exc = new exchange($ecs->table("shop_grade"), $db, 'grade_id', 'is_comment');
/* act操作项的初始化 */

if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

/*------------------------------------------------------ */
//-- 获取没有回复的评论列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 检查权限 */
    admin_priv('comment_priv');

    $smarty->assign('ur_here',      $_LANG['05_order_comment']);
    $smarty->assign('full_page',    1);

    $list = get_order_comment_list();

    $smarty->assign('comment_list', $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();

	$smarty->assign('comment_on', $_CFG['supplier_comment']);
    $smarty->display('order_comment_list.htm');
}


/*------------------------------------------------------ */
//--改变公开状态
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_change')
{
    //check_authz_json('goods_manage');
    $grade_id       = intval($_POST['id']);
    $is_comment        = intval($_POST['val']);
	
    if ($exc->edit("is_comment = '$is_comment'", $grade_id))
    {
        clear_cache_files();
        make_json_result($is_comment);
    }
}

/*------------------------------------------------------ */
//-- 翻页、搜索、排序
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'query')
{
    $list = get_order_comment_list();

    $smarty->assign('comment_list', $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('order_comment_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

/**
 * 获取评论列表
 * @access  public
 * @return  array
 */
function get_order_comment_list()
{
	$supplier_id = $_SESSION['supplier_id'];
	
    /* 查询条件 */
    $filter['keywords']     = empty($_REQUEST['keywords']) ? 0 : trim($_REQUEST['keywords']);
    if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
    {
        $filter['keywords'] = json_str_iconv($filter['keywords']);
    }
    $filter['sort_by']      = empty($_REQUEST['sort_by']) ? 's.add_time' : trim($_REQUEST['sort_by']);
    $filter['sort_order']   = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
    $where = (!empty($filter['keywords'])) ? " AND order_sn LIKE '%" . mysql_like_quote($filter['keywords']) . "%' " : '';
	
    // $sql = "SELECT count(*) FROM " .$GLOBALS['ecs']->table('shop_grade'). " WHERE user_id > 0 $where";
	$sql = "SELECT count(*) FROM " . $GLOBALS['ecs']->table('shop_grade') . " s" . " LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " o"." ON o.order_id = s.order_id"." WHERE s.send > 0 AND o.supplier_id ='$supplier_id'  $where";
	
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);
    /* 分页大小 */
    $filter = page_and_size($filter);

    /* 获取评论数据 */
    $arr = array();
    // $sql  = "SELECT * FROM " .$GLOBALS['ecs']->table('shop_grade'). " WHERE user_id > 0  AND send >0$where " .
            // " ORDER BY $filter[sort_by] $filter[sort_order] ".
            // " LIMIT ". $filter['start'] .", $filter[page_size]";
	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('shop_grade') . " s " . " LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " o "." ON o.order_id = s.order_id "." WHERE  o.supplier_id ='$supplier_id' AND send >0 $where". " ORDER BY $filter[sort_by] $filter[sort_order] ". " LIMIT ". $filter['start'] .", $filter[page_size]";	
			
    $res  = $GLOBALS['db']->query($sql);

    while ($row = $GLOBALS['db']->fetchRow($res))
    {
		$u_name = $row['user_name'];
		$o_id = $row['order_id'];
		$row['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['add_time']);
		$sql = "SELECT AVG(comment_rank) FROM " . $GLOBALS['ecs']->table('comment') . " c" . " LEFT JOIN " . $GLOBALS['ecs']->table('order_goods') . " o"." ON o.goods_id = c.id_value"." WHERE  c.order_id = '$o_id' AND c.order_id = o.order_id";
        $comment_rank = $GLOBALS['db']->getOne($sql);
		$row['comment_rank'] = round($comment_rank,1);
		$row['all_avg'] = round(($row['server']+$row['send']+$row['shipping']+$row['comment_rank'])/4,1);
        $arr[] = $row;
    }

    $filter['keywords'] = stripslashes($filter['keywords']);
    $arr = array('item' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
	

}

?>