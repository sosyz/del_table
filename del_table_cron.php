<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
function cron_del_table() {
    global $m;
    $s = unserialize(option::get('plugin_del_table'));
    $y = $m->query("SELECT * FROM `".DB_PREFIX."del_table`");
    while ($x = $m->fetch_array($y)) {
        $bduss = misc::getCookie($x['pid']);
        $option = array(
                'kw' =>   $x['tieba'],
                'fr'   =>   'index',
        );
        $httpbuild = http_build_query($option);
        $c = new wcurl('http://tieba.baidu.com/f?' . $httpbuild);
        $c->addcookie('BDUSS='.$bduss);
        $data = $c->get();
        $preg = "/<li class=\" j_thread_list.*?\" data-field='([\s\S]*?)'[\s\S]*?<div class=\"threadlist_title pull_left j_th_tit \">[\s\S]*?<a.*?>([\s\S]*?)<\/a>[\s\S]*?<span class=\"tb_icon_author \"[\s\S]*?target=\"_blank\"[\s\S]*?>  <div class=\" j_icon_slot_refresh\">[\s\S]*?<div class=\"threadlist_abs threadlist_abs_onlyline \">([\s\S]*?)<\/div>/s"; 
        $pregtieba = '/PageData[\s\S]*?tbs[\s\S]*?"([\s\S]*?)"[\s\S]*?}[\s\S]*?PageData.forum[\s\S]*?id[\s\S]*?:[\s\S]*?([0-9]*),/s';
        preg_match($pregtieba, $data,$tbinfo);
        preg_match_all($preg, $data, $info);
        var_dump($info);
        unset($info[0]);
        $delkeys = empty($x['delkey'])?array():explode(',', $x['delkey']);
        $mustkeys = empty($x['mustkey'])?array():explode(',',$x['mustkey']);
        foreach ($info[3] as $key => $value) {
            $status = false;
            foreach ($delkeys as $delkey) {
                if(strpos($value,$delkey) !== false){
                    $status = true;
                    goto del;
                }
            }
            if(empty($mustkeys)){
                $status = true;
                goto del;
            }
            foreach ($mustkeys as $mustkey) {
                if(strpos(htmlspecialchars_decode($info[2][$key]),$mustkey) !== false){
                    $status = false;
                    goto del;
                }
            }

            del:
            if($status == false){
                continue;
            }
            $pinfo = json_decode(htmlspecialchars_decode(trim($info[1][$key])),true);
            if($pinfo['author_name'] != $info[3][$key] || strpos($x['white'], $pinfo['author_portrait']) != false){
                continue;
            }

            $option = [
                'commit_fr'  =>  'pb',
                'ie'  =>  'utf-8',
                'tbs'  => $tbinfo[1],
                'kw'  =>  $x['tieba'],
                'fid'  =>  $tbinfo[2],
                'tid'  =>  (string)$pinfo['id'],
                'is_vipdel' => '0',
                'pid' => (string)$pinfo['id'],
                'is_finf' => 'false'
            ];
            $c->setUrl('https://tieba.baidu.com/f/commit/post/delete');
            $c->addcookie('BDUSS='.$bduss);
            $res = $c->post($option);
        }
    }
}
