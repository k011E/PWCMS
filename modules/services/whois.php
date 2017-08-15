<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'WHOIS';
$menu = $title;
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	<form action="" method="GET">
		Введите IP:<br>
		<input type="text" name="ip"><br>
		<input type="submit" value="Показатьч">
	</form>
</div>
<?
if(isset($_GET['ip'])){
	?>
	<div class="lst">
		<?=file_get_contents('http://forum.wen.ru/whois/?ip='.$_GET['ip'].'&w=htm')?>
	</div>
	<?
}
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>