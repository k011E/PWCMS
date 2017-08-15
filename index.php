<?
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'PWCMS';
$where = 'index';
?>
<div class="verx">
	<a href="/">
		<img src="/design/images/logo.png" alt="logo">
	</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
?>
<div class="menu">
	<a href="/news" style="text-decoration:none; color:white;">Новости проекта</a> (<?=$db->query("SELECT `id` FROM `news`")->num_rows?>)
</div>
<?
//300 symbols
$news = $db->query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
$news['content'] = strip_tags($news['content']);
$news['content'] = substr($news['content'], 0, 532);
$news['content'] = rtrim($news['content'], "!,.-");
$news['content'] = substr($news['content'], 0, strrpos($news['content'], ' '));
$ts = time()-86400;
?>
<div class="list1">
<?if($db->query("SELECT `id` FROM `news`")->num_rows==0){
		?>
		Новостей пока нет.
		<?
	}else{?>
	<? echo $Filter->outputText($news['content']).'<br><a href="/news">Читать далее...</a>'?><br>
	Добавил: <?=nick($news['id_us'])?> (<?=datef($news['time'])?>)<br>
	<a href="/komm<?=$news['id']?>">Комментарии</a> (<?=$db->query("SELECT `id` FROM `news_comm` WHERE `id_news`='".$news['id']."'")->num_rows?>)
	<?}?>
</div>
<div class="menu2">
	<a href="/forum" style="text-decoration:none; color:white;">Форум</a> (<?=$db->query("SELECT `id` FROM `forum_t`")->num_rows?>/<?=$db->query("SELECT `id` FROM `forum_p`")->num_rows?>) (<font color="green"><b>+<?=$db->query("SELECT `id` FROM `forum_t` WHERE `time`>".$ts."")->num_rows?></b></font>/<font color="red"><b>+<?=$db->query("SELECT `id` FROM `forum_p` WHERE `time`>".$ts."")->num_rows?></b></font>)
</div>
<div class="ram">
	<?
	$query = $db->query("SELECT * FROM `forum_t` ORDER BY `last` DESC LIMIT 0, ".$UserSettings->getHomeT()."");
	while ($thema = $query->fetch_assoc()) {
		$tp = $db->query("SELECT * FROM `forum_p` WHERE `id_thema`=".$thema['id']."")->num_rows;
		//$pg = round($tp/10,0,PHP_ROUND_HALF_UP);
		$pg = $tp/10;
		$pg2 = intval($pg);
		if($pg>$pg2){
			$pg2++;
		}
		$pg = $pg2;
		?>
		<div class="raz">
			<?=imgT($thema['id'])?> <a href="/forum/thema<?=$thema['id']?>"><?=$Filter->output($thema['name'])?></a> (<?=$db->query("SELECT `id` FROM `forum_p` WHERE `id_thema`=".$thema['id']."")->num_rows?>) <a href="/forum/thema<?=$thema['id']?>/page<?=$pg?>">>></a>
		</div>
		<?
	}
	if($query->num_rows==0){
		?>
		<div class="raz">Тем нет...</div>
		<?
	}?>
</div>
<?
if(!isset($user['id'])){
	?>
	<div class="menu2">
		Меню гостя
	</div>
	<div class="list1">
		<img src="/design/images/acn.gif"> <a href="/log.in.php">Авторизация</a><br>
		<img src="/design/images/acn.gif"> <a href="/reg.php">Регистрация</a><br>
		<img src="/design/images/acn.gif"> <a href="/reamind.php">Восстановление пароля</a><br>
	</div>
<?
}elseif(isset($user['id'])){
	?>
	<div class="menu2">
		Меню пользователя
	</div>
	<div class="list1">
		<img src="/design/images/acn.gif"> <a href="/kab">Личный кабинет</a><br>
		<img src="/design/images/coins.png"> <a href="/kab/money.php">Моя панель</a><br>
		<img src="/design/images/acn.gif"> <a href="/im.php">Именниники</a><br>
		<img src="/design/images/acn.gif"> <a href="/len.php">Новости пользователей</a>(10/100) <font color="red"><b>+1</b></font><br>
		<?if($user['admin']>=1){?>
			<img src="/design/images/acn.gif"> <a href="/admin">Админ-панель</a><br>
			<img src="/design/images/acn.gif"> <a href="/admin/for.php">Админ-форум</a><br>
		<?}?>
		<img src="/design/images/out.png"> <a href="/exit">Выход</a>
	</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>