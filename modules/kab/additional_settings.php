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
$title = 'Настройки';
$menu = 'Настройки - '.$Filter->output($user['nick']);
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
if(isset($_POST['save1'])){
	$UserSettings->setMaxP($_POST['max_p']);
}
if(isset($_POST['save2'])){
	$UserSettings->setHome($_POST['tHome'], $_POST['fHome'], $_POST['cHome']);
}
if(isset($_GET['setTopHome'])){
	$UserSettings->setTopHome();
}
if(isset($_GET['setCommHome'])){
	$UserSettings->setCommHome();
}
if(isset($_GET['setFilesForum'])){
	$UserSettings->setFilesForum();
}
if(isset($_GET['setAds'])){
	$UserSettings->setAds();
}
if(isset($_GET['setSmile'])){
	$UserSettings->setSmile();
}
if(isset($_GET['setViewMail'])){
	$UserSettings->setViewMail();
}
if(isset($_GET['setAjax'])){
	$UserSettings->setAjax();
}
if(isset($_GET['setFilesMail'])){
	$UserSettings->setFilesMail();
}
if(isset($_GET['setNormalNotifications'])){
	$UserSettings->setNormalNotifications();
}
if(isset($_GET['setUpPanel'])){
	$UserSettings->setUpPanel();
}
if(isset($_GET['setFeedAnk'])){
	$UserSettings->setFeedAnk();
}
?>
<div class="list1">
	<form action="" method="POST">
		Пунктов на странице:<br>
		<input type="text" name="max_p" value="<?=$UserSettings->getMaxP()?>"><input type="submit" name="save1" value="Сохранить">
	</form>
</div>
<div class="lst">
	<form action="" method="POST">
		Настройки главной страницы:<br>
		Тем на главной: <input type="text" name="tHome" value="<?=$UserSettings->getHomeT()?>"><br>
		Файлов на главной: <input type="text" name="fHome" value="<?=$UserSettings->getHomeF()?>"><br>
		Кодов на главной: <input type="text" name="cHome" value="<?=$UserSettings->getHomeC()?>"><br>
		<a href="/kab/additional_settings/setTopHome"><?if($UserSettings->getTopHome()==1){?>Скрывать<?}else{?>Показывать<?}?> топ-тему на главной странице</a><br>
		<a href="/kab/additional_settings/setCommHome"><?if($UserSettings->getCommHome()==1){?>Скрывать<?}else{?>Показывать<?}?> темы из форума Общение на главной странице</a><br>
		<input type="submit" name="save2" value="Сохранить">
	</form>
</div>
<div class="list1">
	<a href="/kab/additional_settings/setFilesForum"><?if($UserSettings->getFilesForum()==1){?>Выключить<?}else{?>Включить<?}?></a> добавление файлов в форуме
</div>
<div class="list1">
	<a href="/kab/additional_settings/setAds"><?if($UserSettings->getAds()==1){?>Выключить<?}else{?>Включить<?}?></a> рекламу на сайте
</div>
<div class="list1">
	<a href="/kab/additional_settings/setSmile"><?if($UserSettings->getSmile()==1){?>Выключить<?}else{?>Включить<?}?></a> показ смайлов
</div>
<table cols="3" width="100%" cellpadding="0" cellspacing="0" style="font-size:13px;">
	<tbody>
		<tr>
			<td class="list1" width="30%">Почта: <a href="/kab/additional_settings/setViewMail">вид <?if($UserSettings->getViewMail()==1){?>2<?}else{?>1<?}?></a></td>
			<td class="list1" width="30%">AJAX: <a href="/kab/additional_settings/setAjax"><?if($UserSettings->getAjax()==1){?>выкл<?}else{?>вкл<?}?></a></td>
			<td class="list1" width="40%">Припрекпление файлов: <a href="/kab/additional_settings/setFilesMail"><?if($UserSettings->getFilesMail()==1){?>выкл<?}else{?>вкл<?}?></a></td>
		</tr>
	</tbody>
</table>
<div class="list1">
	<?if($UserSettings->getNormalNotifications()==0){?><a href="/kab/additional_settings/setNormalNotifications">Включить</a> обычные оповещения<?}else{?><a href="/kab/additional_settings/setNormalNotifications">Включить</a> оповещения по категориям<?}?>
</div>

<div class="list1">
	<?if($UserSettings->getUpPanel()==0){?><a href="/kab/additional_settings/setUpPanel">Включить</a><?}else{?><a href="/kab/additional_settings/setUpPanel">Выключить</a><?}?> верхнюю панель
</div>

<div class="list1">
	<?if($UserSettings->getFeedAnk()==0){?><a href="/kab/additional_settings/setFeedAnk">Развернуть</a><?}else{?><a href="/kab/additional_settings/setFeedAnk">Свернуть</a><?}?> новости в анкете
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>