<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Газета';
$menu = $title;
$where = 'gazeta';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>

<?
$n = $db->query("SELECT `id` FROM `users` WHERE `journalist`=2 ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
?>
<div class="menu2">
	Категории
</div>
<?
$query = $db->query("SELECT * FROM `gazeta_sections`");
while ($section = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<img src="/design/images/news_subscribe.png"> <a href="/gazeta/section/<?=$section['id']?>"><?=$Filter->output($section['name'])?></a> [<?=$db->query("SELECT `id` FROM `gazeta_articles` WHERE `id_r`=".$section['id']."")->num_rows?>] <?if($user['admin']>=3 OR $user['journalist']==2){?>[<a href="/gazeta/admin/delete_section/<?=$section['id']?>">x</a>] [<a href="/gazeta/admin/edit_section/<?=$section['id']?>">ред</a>]<?}?>
	</div>
	<?
}
?>
<div class="list1">
	Главный редактор: <?=nick($n['id'])?>
</div>
<div class="list1">
	<a href="/gazeta/journalists">Журналисты газеты</a>
</div>
<?
if($user['admin']>=3 OR $user['journalist']==2){
	?>
	<div class="list1">
		<a href="/gazeta/admin/">Админка</a>
	</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>