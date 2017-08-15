<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Удаление темы';
$menu = $title;
$where = 'forum';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
admin(3);
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `forum_t` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	header('location:/forum');
	exit();
}
$thema = $query->fetch_assoc();
if($thema['type']==1){
	error('Тема уже удалена!');
}
if(isset($_POST['yes'])){
	$db->query("UPDATE `forum_t` SET `type`=1, `last`='".time()."' WHERE `id`='".$_GET['id']."'");
	$db->query("INSERT INTO `forum_p` SET `id_r`='".$thema['id_r']."', `id_pr`='".$thema['id_pr']."', `msg`='[b]Тема была удалена :-)[/b]', `type`=0, `id_us`='".$user['id']."', `time`='".time()."', `id_thema`='".$thema['id']."'");
	header('location:/forum/thema'.$thema['id']);
}elseif(isset($_POST['no'])){
	header('location:/forum/thema'.$thema['id']);
}
?>
<div class="lst">
	<form action="" method="POST">
		Вы действительно хотите удалить данную тему (<a href="/forum/thema<?=$thema['id']?>"><?=$Filter->output($thema['name'])?></a>)?<br>
		<input type="submit" name="yes" value="Да">
		<input type="submit" name="no" value="Нет">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>