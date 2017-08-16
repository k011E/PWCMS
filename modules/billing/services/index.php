<?php
$title = $menu = 'Моя панель';
$where = 'billing';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	<img src="/design/images/mon.gif"> Мой баланс: <b><?=$user['money']?>р</b>
</div>
<div class="lst">
	<a href="/billing/services/attachment">Прикрепление тем</a>
</div>
<div class="lst">
	<a href="/billing/services/ads">Заказать рекламу</a>
</div>
<div class="lst">
	<a href="/billing/services/clear_pen">Очистка нарушений</a>
</div>
<div class="lst">
	<a href="/billing/services/gradient">Градиент ника</a>
</div>
<div class="lst">
	<a href="/billing/services/flashing">Мигание ника</a>
</div>
<div class="lst">
	<a href="/billing/services/status">Личный статус</a>
</div>
<div class="lst">
	<a href="/billing/services/icon">Иконка возле ника</a>
</div>
<div class="lst">
	<a href="/billing/services/change_nick">Экспресс смена ника</a>
</div>
<div class="navg">
	<img src="/design/images/home0.png">
	<a href="/billing">Моя панель</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>