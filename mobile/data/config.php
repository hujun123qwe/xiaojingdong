<?php
// database host
$db_host   = "localhost:3306";

// database name
$db_name   = "liantu";

// database username
$db_user   = "liantu";

// database password
$db_pass   = "zy77813";

// table prefix
$prefix    = "ecs_";

$timezone    = "PRC";

$cookie_path    = "/";

$cookie_domain    = "";

$session = "1440";

define('EC_CHARSET','utf-8');

/*start  By  QQ:485329944 */
if(!defined('ADMIN_PATH'));
{
define('ADMIN_PATH','admin');
}
/*start  By  QQ:485329944 */
if(!defined('ADMIN_PATH_M'));
{
define('ADMIN_PATH_M','admin');
}
define('AUTH_KEY', 'this is a key');

define('OLD_AUTH_KEY', '');

define('API_TIME', '');

?>