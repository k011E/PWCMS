<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Админка газеты';
$menu = $title;
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if($user['admin']<3 AND $user['journalist']!=2){
	header('location:/gazeta');
}
?>
<div class="lst">
	Привет, <?=nick($user['id'])?>. Ты находишься в админке газеты, а занчит, что ты являешься главным редактором!
</div>
<div class="list1">
	<a href="/gazeta/admin/join_journalist">Назначить журналистом</a>
</div>
<div class="list1">
	<a href="/gazeta/admin/delete_journalist">Снять с должности журналиста</a>
</div>
<div class="list1">
	<a href="/gazeta/admin/add_section">Добавление раздела</a>
</div>
<div class="menu">
	Журналисты газеты
</div>
<?
$query = $db->query("SELECT `id` FROM `users` WHERE `journalist`>=1");
while ($us = $query->fetch_assoc()) {
	?>
	<div class="list1">
		<?=nick($us['id'])?> [<a href="/gazeta/admin/delete_journalist/<?=$us['id']?>">x</a>]
	</div>
	<?
}
?>
<div class="navg">
	<a href="/gazeta">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>