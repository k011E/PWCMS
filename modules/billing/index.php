<?php
$menu = $title = 'Моя панель';
$where = 'billing';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="list1">
	<img src="/design/images/mon.gif" alt="money">
	Мой баланс: <b><?=$user['money']?>р</b>
</div>
<div class="lst">
	<a href="/all/info.php?i=bil">FAQ</a>
</div>
<div class="lst">
	<a href="/billing/refill"><img src="/design/images/addr.png" class="ico">Пополнение баланса</a>
</div>
<div class="lst">
	<a href="/billing/output"><img src="/design/images/vyvod.png" class="ico">Запросить вывод</a>
</div>
<div class="lst">
	<a href="/billing/transfer"><img src="/design/images/money_arrow.png" class="ico">Перевод средств</a>
</div>
<div class="lst">
	<a href="/billing/transfers"><img src="/design/images/zzz.png" class="ico">Переводы</a>
</div>
<div class="lst">
	<a href="/billing/scores"><img src="/design/images/sc.png" class="ico">Счета</a>
</div>
<div class="lst">
	<a href="/billing/operations"><img src="/design/images/ope.png" class="ico">Операции</a>
</div>
<div class="lst">
	<a href="/billing/purses"><img src="/design/images/keep.png" class="ico">Мои кошельки</a>
</div>
<div class="lst">
	<a href="/billing/services"><img src="/design/images/servs.png" class="ico">Услуги</a>
</div>
<div class="lst">
	<a href="/billing/fund"><img src="/design/images/money_safe.png" class="ico">Фонд сайта</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>