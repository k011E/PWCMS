<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
include_once($_SERVER["DOCUMENT_ROOT"].'/system/includes_system.php');
mode('user');
$_GET['id'] = abs(intval($_GET['id']));
if($user['admin']<3){
	header('location:/');
}
$query = $db->query("SELECT * FROM `senks` WHERE `id`=".$_GET['id']."");
if($query->num_rows==0){
	header('location:/');
}else{
	$senk = $query->fetch_assoc();
	$db->query("DELETE FROM `senks` WHERE `id`=".$_GET['id']."");
	header('location:/senks'.$senk['id_us']);
}
?>