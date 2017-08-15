<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Проверка WMID';
$menu = $title;
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
if(isset($_GET['wmid'])){
	$_GET['wmid'] = $Filter->input($_GET['wmid']);
	if(mb_strlen($_GET['wmid'])!=12){
		error('Ошибка! WMID должен состоять из 13 цифр! <a href="/services/wmid">Назад</a>');
	}
	if($db->query("SELECT `id` FROM `users` WHERE `wmid`=".$_GET['wmid']."'")->num_rows!=0){
		$wma = $db->query("SELECT `id` FROM `users` WHERE `wmid`=".$_GET['wmid']."'")->fetch_assoc();
		$wmb = nick($wma['id']);
	}else{
		$wmb = 'Пользователь с таким WMID не зарегистрирован.';
	}
	?>
	<div class="lst">
		<b>WMID:</b> <a href="https://passport.webmoney.ru/asp/certview.asp?wmid=<?=$Filter->output($_GET['wmid'])?>"><?=$Filter->output($_GET['wmid'])?></a><br>
		<b>Пользователь:</b> <?=$wmb?><br>
		<b>BL:</b> <img src="https://bl.wmtransfer.com/img/bl/<?=$Filter->output($_GET['wmid'])?>?w=45&h=18&bg=0XDBE2E9.png"><br>
		<b>Претензии / Отзывы / Иски:</b> <a href="http://arbitrage.webmoney.ru/asp/claims.asp?wmid=<?=$Filter->output($_GET['wmid'])?>"><img src="http://arbitrage.webmoney.ru/xml/AL2.aspx?wmid=<?=$Filter->output($_GET['wmid'])?>"></a><br>
		<form action="http://arbitrage.webmoney.ru/asp/newclaims.asp">
			<input type="submit" value="Написать Претензию" />
			<input type="hidden" name="procwmid" value="">
		</form>
	</div>
	<?
}
?>
<div class="list1">
	<form action="" method="GET">
		WMID:<br>
		<input type="text" name="wmid" size="13" maxlength="13"><br>
		<input type="submit" value="Проверить">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>