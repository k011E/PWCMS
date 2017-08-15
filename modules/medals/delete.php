<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Удаление медали';
$menu = $title;
$where = 'page_user';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(3);
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `medals` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	error('Медали не существует.');
}
$medal = $query->fetch_assoc();
if(isset($_POST['yes'])){
	$db->query("DELETE FROM `medals` WHERE `id`='".$medal['id']."'");
	header('location:/medals/'.$medal['id_us']);
}elseif(isset($_POST['no'])){
	header('location:/medals/'.$medal['id_us']);
}
?>
<div class="list1">
	Вы действительно хотите удалить медаль выданную пользователю <?=nick($medal['id_us'])?> администратором <?=nick($medal['id_adm'])?> за <?=$Filter->output($medal['for_what'])?><br>
	<form action="" method="POST">
		<input type="submit" name="yes" value="Да">
		<input type="submit" name="no" value="Нет">
	</form>
</div>
<div class="navg">
	<a href="/medals/<?=$medal['id_us']?>">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>