<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
function cron_del_table() {
    global $m;
    $s = unserialize(option::get('plugin_del_table'));
    $y = $m->query("SELECT * FROM `".DB_PREFIX."del_table`");
    while ($x = $m->fetch_array($y)) {
        $bduss = misc::getCookie($x['pid']);
        $option = [
                'kw' =>   $x['tieba'],
                'fr'   =>   'index',
            ];
        $httpbuild = http_build_query($option);
        $c = new wcurl('http://tieba.baidu.com/f?' . $httpbuild);
        $c->addcookie('BDUSS='.$bduss);
        $data = $c->get();
        $preg = "/<li class=\" j_thread_list clearfix\" data-field='(.*?)'.*?<div class=\"threadlist_title pull_left j_th_tit \">.*?<a.*?>(.*?)<\/a>.*?<span class=\"tb_icon_author \".*?target=\"_blank\">(.*?)<\/a>.*?<div class=\"threadlist_abs threadlist_abs_onlyline \">(.*?)<\/div>/s"; 
        $pregtieba = '/tbs.*?"(.*?)".*?}.*?PageData.forum.*?id.*?:.*?([0-9]*),/s';
        preg_match($pregtieba, $data,$tbinfo);
        preg_match_all($preg, $data, $info);
        unset($info[0]);
        $delkeys = empty($x['delkey'])?array():explode(',', $x['delkey']);
        $mustkeys = empty($x['mustkey'])?array():explode(',',$x['mustkey']);
        foreach ($info[4] as $key => $value) {
            $status = true;
            foreach ($delkeys as $delkey) {
                if(strpos($value,$delkey) !== false){
                    $status = true;
                    goto del;
                }
            }
            if(empty($mustkeys)){
                $status = false;
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
            if($pinfo['author_name'] != $info[3][$key]){
                continue;
            }
            $option = [
                'commit_fr'  =>  'pb',
                'ie'  =>  'utf-8',
                'tbs'  => $tbinfo[1],
                'kw'  =>  $x['tieba'],
                'fid'  =>  $tbinfo[2],
                'tid'  =>  (string)$pinfo['id'],
            ];
            $c->setUrl('http://tieba.baidu.com/f/commit/thread/delete');
            $c->addcookie('BDUSS='.$bduss);
            $res = $c->post($option);
        }
    }
}
