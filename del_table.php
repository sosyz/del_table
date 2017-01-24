<?php
/*
Plugin Name: 自动删帖
Version: 0.1
Plugin URL: https://www.ddnpc.com
Description: 根据关键词进行删帖
Author: Instrye
Author Email: instrye@gmail.com
Author URL: https://www.ddnpc.com
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