<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
include_once($_SERVER["DOCUMENT_ROOT"].'/system/class/Filter.php');
$Filter = new Filter;
if(isset($_COOKIE['tocken'])){
	$_COOKIE['tocken'] = $Filter->clearString($_COOKIE['tocken']);
	if($db->query("SELECT `id` FROM `users` WHERE `tocken`='".$_COOKIE['tocken']."'")->num_rows!=0){
		$user = $db->query("SELECT * FROM `users` WHERE `tocken`='".$_COOKIE['tocken']."'")->fetch_assoc();
		$db->query("UPDATE `users` SET `where`='".$where."' WHERE `id`='".$user['id']."'");
		if($user['online']+1<time()){
			$db->query("UPDATE `users` SET `online`=".time()." WHERE `id`=".$user['id']."");
			$db->query("UPDATE `users` SET `time_online`=`time_online`+1 WHERE `id`='".$user['id']."'");
			$db->query("INSERT INTO `log` SET `id_us`='".$user['id']."', `time`='".time()."', `page`='".$_SERVER["REQUEST_URI"]."'");
			$db->query("UPDATE `users` SET `ip`='".$_SERVER["REMOTE_ADDR"]."', `ua`='".$_SERVER["HTTP_USER_AGENT"]."' WHERE `id`=".$user['id']."");
		}
	}
}

$db->query("DELETE FROM `repass` WHERE `time`<".(time()-86400)." OR `activation`=1");
?>