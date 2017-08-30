<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }

function callback_init() {
	global $m;
	$m->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."del_table` (
`id`  int(255) NOT NULL AUTO_INCREMENT ,
`uid`  int(255) NOT NULL ,
`pid`  int(255) NOT NULL ,
`cookies` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`tieba`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`delkey`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`mustkey`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=12
CHECKSUM=0
ROW_FORMAT=DYNAMIC
DELAY_KEY_WRITE=0;");
	cron::set('del_table','plugins/del_table/del_table_cron.php',0,0,0);
}

function callback_inactive() {
	cron::del('del_table');
}

function callback_remove() {
	global $m;
	$m->query("DROP TABLE IF EXISTS `".DB_PREFIX."del_table`");
	option::del('plugin_del_table');
}
?>
