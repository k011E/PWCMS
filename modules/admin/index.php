<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Админ-панель';
$where = 'admin';
$menu = $title;
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
admin(1);
?>
<?if($user['admin']==4){
	?>
	<div class="menu2">
		Панель создателя
	</div>
	<div class="lst"><a href="/admin/system/info_system">Информация о CMS</a></div>
	<div class="lst"><a href="/admin/billing">Управление биллингом</a></div>
	<?
}?>

<?if($user['admin']>=2){?>
	<div class="menu2">
		Админ-панель
	</div>
<?}?>
<?if($user['admin']>=3){?>
	<div class="lst"><a href="/admin/news">Управление новостями</a></div>
	<div class="lst"><a href="/admin/forum">Управление форумом</a></div>
	<div class="lst"><a href="/admin/smiles">Управление смайлами</a></div>
<?}?>
<div class="menu2">
	Модер-панель
</div>
<div class="lst"><a href="/admin/tickets">Тикеты</a> [4/1000]</div>
<div class="lst"><a href="/admin/banlist">Бан-лист</a> [2000]</div>
<div class="lst"><a href="/admin/deletes">Самобаны</a> [50]</div>
<div class="lst"><a href="/admin/nar">Нарушения</a> [10000]</div>
<div class="lst"><a href="/admin/complaints">Жалобы</a> [90]</div>
<div class="lst"><a href="/admin/appeal">Обжалование бана</a> [21]</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>