<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$_GET['id'] = abs(intval($_GET['id']));
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
$where = 'page_user';
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
mode('user');
if($db->query("SELECT * FROM `users` WHERE `id`='".$_GET['id']."'")->num_rows==0){
	header('location:/');
}
$us = $db->query("SELECT * FROM `users` WHERE `id`='".$_GET['id']."'")->fetch_assoc();
$title = 'Страница '.$us['nick'];
$menu = nick($us['id']);
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
$Forum = new Forum(0);
switch ($us['admin']) {
	case '1':
		$admin = 'Модер';
		break;
	
	case '2':
		$admin = 'Админ';
		break;

	case '3':
		$admin = 'Ст. Админ';
		break;

	case '4':
		$admin = 'Создатель';
		break;

	default:
		$admin = 'Пользователь';
		break;
}

if($us['rating']<'0.21'){
	$status = 'Новичок';
}elseif($us['rating']>='0.21' AND $us['rating']<'0.50'){
	$status = 'Продвинутый';
}elseif($us['rating']>='0.50' AND $us['rating']<'3.00'){
	$status = 'Узнаваемый';
}elseif($us['rating']>='3.00' AND $us['rating']<'10.00'){
	$status = 'Здешний';
}elseif($us['rating']>='10.00' AND $us['rating']<'50.00'){
	$status = 'Уважаемый';
}elseif($us['rating']>='50.00' AND $us['rating']<'100.00'){
	$status = 'V.I.P';
}elseif($us['rating']>'100.00' OR !empty($us['status'])){
	$status = $us['status'];
}
?>
<?if($user['admin']>=1 AND $user['admin']>=$us['admin']){
	?>
	<div class="lst">
		<a href="/us<?=$us['id']?>/change_nick">Сменить ник</a>
	</div>
	<?
}
if($user['admin']>=2 AND $user['admin']>=$us['admin']){
	?>
	<div class="lst">
		<a href="/us<?=$_GET['id']?>/edit">Редактировать пользователя</a>
	</div>
	<div class="lst">
		<a href="/us<?=$_GET['id']?>/change_password">Сменить пароль</a>
	</div>
	<div class="lst">
	<?if($us['scam']==0){?>
		<a href="/us<?=$_GET['id']?>/scam/true">Повесить клеймо мошенника</a>
	<?}else{?>
		<a href="/us<?=$_GET['id']?>/scam/false">Снять клеймо мошенника</a>
	<?}?>
	</div>
	<?
}
if($user['admin']>=3 OR $user['journalist']==2){
	if($us['journalist']==0){
		?>
		<div class="lst"><a href="/gazeta/admin/join_journalist/<?=$us['id']?>">Назначить журналистом</a></div>
		<?
	}else{
		?>
		<div class="lst"><a href="/gazeta/admin/delete_journalist/<?=$us['id']?>">Снять с журналиста</a></div>
		<?
	}
}
?>
<div class="list1">
	<span style="color: #818181">» Зарегистрирован</span> <?=datef($us['time_reg'])?><br>
	<span style="color: #818181">» Последняя активность:</span> <?=datef($us['online'])?> [<b><?=where($us['id'])?></b>]<br>
	<span style="color: #818181">» Провёл на сайте:</span> <?=timef($us['time_online'])?><br>
	<span style="color: #818181">» Уровень:</span> <b><font color="green"><?=$admin?></font></b><?if($us['journalist']>0){?> | <font color="red"><b>Журналист газеты</b></font><?}?>
</div>
<div class="list1">
	<?if(file_exists($_SERVER["DOCUMENT_ROOT"].'/files/avs/'.$us['id'].'.jpg')){
		?>
		<img src="/files/avs/<?=$us['id']?>.jpg" style="max-width: 208px; max-height: 208px;" alt="*">
		<?
	}else{
		?>
		<img src="/design/images/nfound.png" alt="*">
		<?
	}
	?>
	<?if($us['id']!=$user['id']){?>
		<br><br>
		<img src="/design/images/004.png"> <a href="/mail/msg/<?=$us['id']?>">Написать сообщение</a><br>
		<?if($db->query("SELECT `id` FROM `mail_ignor` WHERE `who`=".$user['id']." AND `whom`=".$us['id']."")!=0){?>
			<img src="/design/images/stop_2.png"> <a href="/mail/msg/<?=$us['id']?>?ignor">В игнор</a><br>
		<?}else{?>
			<img src="/design/images/yes.png"> 
		<?}?>
		<?if($db->query("SELECT `id` FROM `subscribes` WHERE `subscriber`=".$user['id']." AND `to`=".$us['id']."")->num_rows==0){
			?>
			<img src="/design/images/kontact_news.png"> <a href="/us<?=$us['id']?>/subscribe">Подписаться на новости</a>
			<?
		}else{
			?>
			<img src="/design/images/news_unsubscribe.png"> <a href="/us<?=$us['id']?>/unsubscribe">Отписаться от новостей</a>
			<?
		}
	}?>
</div>
<div class="list1">
	» ID: <?=$us['id']?><br>
	» Статус:  <font color="green"><?=$Filter->output($status)?></font><br>
	» Награды: <a href="/medals/<?=$us['id']?>"><?=$db->query("SELECT `id` FROM `medals` WHERE `id_us`='".$us['id']."'")->num_rows?></a> :<?
	$query = $db->query("SELECT `medal` FROM `medals` WHERE `id_us`='".$us['id']."'");
	while ($medal = $query->fetch_assoc()) {
		?><img src="/design/images/medals/<?=$medal['medal']?>.png" alt="*"><?
	}
	?>
</div>
<div class="menu2">
	Личные данные
</div>
<div class="ram">
	<div class="raz">
		<img src="/design/images/ups.png" alt="*">
		<a href="/us<?=$us['id']?>/nicks">История ников</a> (<?=$db->query("SELECT `id` FROM `history_nick` WHERE `id_us`='".$us['id']."'")->num_rows?>)
	</div>
	<?
	if(isset($_GET['nicks'])){
		?>
		<div class="list1">
			<?
			$query = $db->query("SELECT * FROM `history_nick` WHERE `id_us`='".$us['id']."' ORDER BY `time` DESC");
			while ($nick = $query->fetch_assoc()) {
				?>
				<b><?=$Filter->output($nick['old'])?></b> -> <b><?=$Filter->output($nick['new'])?></b><br>
				Сменил: <?=nick($nick['id_adm'])?> (<?=datef($nick['time'])?>)
				<hr>
				<?
			}?>
		</div>
		<?
	}
	?>
	<?if(!empty($us['name'])){?>
		<div class="list1">Имя: <?=$Filter->output($us['name'])?></div>
	<?}?>
	<?if(!empty($us['sex'])){?>
		<div class="list1">Пол: <?=$Filter->output($us['sex'])?></div>
	<?}?>
	<?if(!empty($us['birth'])){?>
		<div class="list1">Дата рождения: <?=$Filter->output($us['birth'])?></div>
	<?}?>
	<?if(!empty($us['country'])){?>
		<div class="list1">Страна: <?=$Filter->output($us['country'])?></div>
	<?}?>
	<?if(!empty($us['city'])){?>
		<div class="list1">Город: <?=$Filter->output($us['city'])?></div>
	<?}?>
	<?if(!empty($us['info'])){?>
		<div class="list1">О себе: <?=$Filter->output($us['info'])?></div>
	<?}?>
	<?if(!empty($us['email'])){?>
		<div class="list1">E-Mail: <?=$Filter->output($us['email'])?></div>
	<?}?>
	<?if(!empty($us['icq'])){?>
		<div class="list1">ICQ: <?=$Filter->output($us['icq'])?></div>
	<?}?>
</div>

<div class="menu2">
	Информация и активность
</div>

<div class="list1">
	<img src="/design/images/theme.png"> Тем в <a href="/thems<?=$us['id']?>">форуме</a>: <?=$Forum->themsUsCount($us['id'])?>
</div>

<div class="list1">
	<img src="/design/images/txt4.png"> Постов в <a href="/posts<?=$us['id']?>">форуме</a>: <?=$Forum->msgUserCount($us['id'])?>
</div>

<div class="menu2">
	Репутация на сайте
</div>
<div class="list1">
	<img src="/design/images/pods.png"> <a href="/us<?=$us['id']?>/subscribes">Подписчики</a> [<?=$db->query("SELECT `id` FROM `subscribes` WHERE `to`=".$us['id']."")->num_rows?>]
</div>
<div class="list1">
	<img src="/design/images/clean.png"> <a href="/senks<?=$us['id']?>">Поблагодарили</a> [<?=$db->query("SELECT `id` FROM `senks` WHERE `id_us`=".$us['id']."")->num_rows?>]
</div>
<div class="list1">
	<img src="/design/images/rating.png"> Рейтинг: <?=$us['rating']?>
</div>
<?
if($user['admin']>=1){
	?>
	<div class="menu2">
		Админ-панель
	</div>
	<div class="list1">
		IP: <?=$Filter->output($us['ip'])?> [<a href="/services/whois?ip=<?=$Filter->output($us['ip'])?>">.!.</a>]<br>
		UA: <?=$Filter->output($us['ua'])?>
	</div>
	<div class="list1">
		<a href="/kab/log/<?=$us['id']?>">Логи авторизаций</a>
	</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>