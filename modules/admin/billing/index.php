<?php
$title = 'Упраление биллингом';
$menu = '<a href="/admin" style="color: white;">Админ-панель</a> | Управление биллингом';
$where = 'admin';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
admin(4);
?>
<div class="lst">
	<a href="/admin/billing/prices">Настройка цен</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>