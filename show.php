<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } global $m,$i,$s; ?>
<input type="button" data-toggle="modal" data-target="#del_table" class="btn btn-info btn-lg" value="+ 添加删帖规则" style="float:right;">
<h2>自动删帖</h2>

以下为删帖规则列表，若要增加新的规则，请点击右侧的 增加删帖规则 按钮
<br/><br/>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>PID</th>
            <th style="width:20%">贴吧</th>
            <th style="width:20%">Cookie</th>
            <th style="width:20%">删除关键词</th>
            <th style="width:20%">必须包含关键词</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $x = $m->query("SELECT * FROM `".DB_PREFIX."del_table` WHERE `uid` = ".UID);
        while($v = $m->fetch_array($x)) {
        ?>
        <tr>
            <td><?php echo $v['id'] ?></td>
            <td><?php echo $v['pid'] ?></td>
            <td><?php echo $v['tieba'] ?></td>
            <td><?php echo mb_substr($v['cookies'],0,20)?></td>
            <td><?php echo $v['delkey'] ?></td>
            <td><?php echo $v['mustkey'] ?></td>
            <td>
                <a class="btn btn-default" href="index.php?plugin=del_table&amp;mod=del&amp;id=<?php echo $v['id'] ?>" title="删除">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
</script>
<div class="modal fade" id="del_table" tabindex="-1" role="dialog" aria-labelledby="del_table" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="del_table_title">添加删帖规则</h4>
      </div>
      <form action="index.php?plugin=del_table&mod=add" method="post">
      <div class="modal-body">
        要操作的贴吧名称后面不要带 <b>吧</b>，<br>删除关键词为内容包含关键词就删除先行判断,<br>必须包含关键词为标题必须包含<br/>
        多个关键词 <b>,</b>分割
        <br/>
        <div class="input-group">
            <span class="input-group-addon">选择封禁发起人账号ID [PID]</span>
            <select name="pid" class="form-control" id="pid"><?php foreach ($i['user']['bduss'] as $keyyy => $valueee) {echo '<option value="'.$keyyy.'">'.$keyyy.'</option>';} ?></select>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon">要操作的贴吧名称</span>
            <input type="text" name="tieba" class="form-control" id="tieba">
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon">Cookies</span>
            <input type="text" name="cookies" class="form-control" id="cookies">
            <span class="input-group-addon">插件获取</span>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon">删除关键词</span>
            <input type="text" name="delkey" class="form-control" id="delkey">
        </div>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon">标题必须包含</span>
            <input id="mustkey" type="text" name="mustkey" class="form-control">
        </div>
        <br/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary" id="runsql_button">提交更改</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<br/><br/>作者：<a href="https://www.ddnpc.com" target="_blank">Instrye</a>
