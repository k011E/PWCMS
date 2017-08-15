<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Сервисы сайта';
$menu = $title;
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	» <a href="/services/screen">Скриншотер сайтов</a>
</div>
<div class="list1">
	» <a href="/services/wmid">Проверить WMID</a>
</div>
<div class="list1">
	» <a href="/services/resize">Ресайз изображений</a>
</div>
<div class="list1">
	» <a href="/services/whois">Whois</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>