<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `forum_pr` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	header('location:/forum');
}
$pr = $query->fetch_assoc();
$title = 'Правила подраздела "'.$Filter->input($pr['name']).'"';
$menu = $title;
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	<?=$Filter->output($pr['rules'])?>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>