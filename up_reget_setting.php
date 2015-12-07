<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
if(isset($_GET['all'])){
	global $m;
	$result = $m->query("SELECT `bduss` FROM `".DB_NAME."`.`".DB_PREFIX."baiduid`");
	$allrow = $result->num_rows;
	$onrow = 0;
	while($onrow < $allrow) {
		$bduss = $m->fetch_array($result);
		$bduss = $bduss['bduss'];
		$bdid = getBaiduId($bduss);
		$m->query("UPDATE `".DB_NAME."`.`".DB_PREFIX."baiduid` SET `name` = '{$bdid}' WHERE `bduss` = '{$bduss}'");
		$onrow = $onrow + 1;
	}
	echo'<div class="alert alert-success">成功刷新了本站'."{$allrow}条绑定的百度用户名信息！</div>";
}
elseif(isset($_GET['empty'])){
	global $m;
	$result = $m->query("SELECT `bduss` FROM `".DB_NAME."`.`".DB_PREFIX."baiduid` WHERE `name` = ''");
	$allrow = $result->num_rows;
	$onrow = 0;
	while($onrow < $allrow) {
		$bduss = $m->fetch_array($result);
		$bduss = $bduss['bduss'];
		$bdid = getBaiduId($bduss);
		$m->query("UPDATE `".DB_NAME."`.`".DB_PREFIX."baiduid` SET `name` = '{$bdid}' WHERE `bduss` = '{$bduss}'");
		$onrow++;
	}
	echo'<div class="alert alert-success">成功获取了本站为空的'."{$allrow}条百度用户名信息！</div>";
}
elseif(isset($_GET['delem'])){
	global $m;
	$result = $m->query("SELECT `uid`,`id` FROM `".DB_NAME."`.`".DB_PREFIX."baiduid` WHERE `name` = ''");
	$allrow = $result->num_rows;
	$onrow = 0;
	while($onrow < $allrow) {
		$info=$m->fetch_array($result);
		$uid=$info['uid'];
		$t=$m->once_fetch_array("SELECT `t` FROM  `".DB_NAME."`.`".DB_PREFIX."users` WHERE  `id` = '{$uid}'");
		if(!empty($t)){/*特殊情况：绑定信息对应用户不存在*/
			$t=$t['t'];
			$pid=$info['id'];
			$m->query("DELETE FROM `".DB_NAME."`.`".DB_PREFIX.$t."` WHERE `pid` = '{$pid}'");
		}
		$m->query("DELETE FROM `".DB_NAME."`.`".DB_PREFIX."baiduid` WHERE `id` = '{$pid}'");
		$onrow++;
	}
	echo'<div class="alert alert-success">成功获取了本站为空的'."{$allrow}条百度用户名信息！</div>";
}
?>
	<h4>请选择模式：</h4>
	1.获取百度用户名</br>
	<a href='/index.php?mod=admin:setplug&plug=up_reget&all'>刷新全部绑定</a></br>
	<a href='/index.php?mod=admin:setplug&plug=up_reget&empty'>只获取无百度用户名的绑定</a></br>
	</br>2.删除绑定</br>
	<a href='/index.php?mod=admin:setplug&plug=up_reget&delem'>删除无百度用户名的绑定</a></br>
