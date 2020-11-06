<?php
/*
Plugin Name: 自动删帖
Version: 0.2
Plugin URL: https://github.com/sosyz/del_table
Description: 根据关键词进行删帖
Author: Sonui
Author Email: 814146039@qq.com
Author URL: https://github.com/sosyz/del_table
For: V3.1+
*/
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function del_table_addaction_navi() {
	?>
	<li <?php if(isset($_GET['plugin']) && $_GET['plugin'] == 'del_table') { echo 'class="active"'; } ?>><a href="index.php?plugin=del_table"><span class="glyphicon glyphicon-ban-circle"></span> 自动删帖</a></li>
	<?php
}
addAction('navi_1','del_table_addaction_navi');
addAction('navi_7','del_table_addaction_navi');