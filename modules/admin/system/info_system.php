<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Информация об установленой CMS';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
admin(4);
$system_info = $db->query("SELECT * FROM `system_info` WHERE `id`=1")->fetch_assoc();
?>
<div class="list1">
	Имя: <?=$Filter->output($system_info['name'])?>
</div>
<div class="list1">
	Лицензия: <?=$Filter->output($system_info['licension'])?>
</div>
<div class="list1">
	Версия: <?=$Filter->output($system_info['version'])?>
</div>
<div class="list1">
	Версия сборки: <?=$Filter->output($system_info['version_build'])?>
</div>
<?
$arr = file_get_contents("http://pwcms.ru/last_version.json");
$arr = json_decode($arr, true);
if($arr['version_build']!=$system_info['version_build']){
	?>
	<div class="lst">
		<b>Внимание!</b>
		Вы используете устаревшую версию системы (<?=$Filter->output($system_info['version'])?>). В данный момент актуальная версия <?=$Filter->output($arr['version'])?>, мы рекомендуем Вам обновиться, чтобы защитить свой сайт от уязвимостей, а также получить новый функционал. Скачать новую сборку Вы можете на <a href="http://pwcms.ru">официальном сайте</a> PWCMS
	</div>
	<?
}
?>
<div class="navg">
	<a href="/admin">Обратно</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>