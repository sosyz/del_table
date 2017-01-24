<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }  
global $i,$m;
$s = unserialize(option::get('plugin_del_table'));
if (SYSTEM_PAGE == 'add') {
    $pid   = !empty($_POST['pid']) ? intval($_POST['pid']) : msg('请选择PID');
    if (!isset($i['user']['bduss'][$pid])) {
        msg('PID不存在');
    }
    $tieba = !empty($_POST['tieba']) ? addslashes(strip_tags($_POST['tieba'])) : msg('请输入贴吧');
    $delkey = $_POST['delkey'] != null?$_POST['delkey']:'';
    $mustkey = $_POST['mustkey'] != null?$_POST['mustkey']:'';
    if(empty($delkey) && empty($mustkey)){
        msg('请至少选择一中删帖模式');
    }
    $m->query("INSERT INTO `".DB_PREFIX."del_table` (`uid`, `pid`, `tieba`, `delkey`, `mustkey`) VALUES ('".UID."', '{$pid}', '{$tieba}', '{$delkey}', '{$mustkey}')");
    ReDirect(SYSTEM_URL . 'index.php?plugin=del_table&ok');
} elseif (SYSTEM_PAGE == 'del') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : msg('缺少ID');
    $m->query("DELETE FROM `".DB_PREFIX."del_table` WHERE `uid` = ".UID." AND `id` = ".$id);
    ReDirect(SYSTEM_URL . 'index.php?plugin=del_table&ok');
} else {
    loadhead();
    require SYSTEM_ROOT.'/plugins/del_table/show.php';
    loadfoot(); 
} 
