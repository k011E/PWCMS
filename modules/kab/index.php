<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
$title = 'Личный кабинет';
$where = 'kab';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
?>
<div class="menu2">
	<a href="/gazeta" style="color: white;">Газета</a> (<?=$db->query("SELECT `id` FROM `gazeta_articles`")->num_rows?>)
</div>

<div class="ram">
	<?
	$query = $db->query("SELECT * FROM `gazeta_articles` ORDER BY `id` DESC LIMIT 0, 3");
	while ($article = $query->fetch_assoc()) {
		?>
		<div class="raz">
			<img src="/design/images/newspaper.png">
			<a href="/gazeta/article/<?=$article['id']?>"><?=$Filter->output($article['name'])?></a>
		</div>
		<?
	}
	?>
</div>

<div class="menu2">
	Информация
</div>

<div class="list1">
	<?=nick($user['id'])?>
</div>
<div class="list1">
	<img src="/design/images/mai5l.png" alt="*">
	<a href="/mail">Почта</a>
</div>

<div class="list1">
	<img src="/design/images/rss.png" alt="*">
	<a href="/notifications<?if($UserSettings->getNormalNotifications()==0){?>h<?}?>">Оповещения</a>
</div>

<div class="list1">
	<img src="/design/images/newspaper.png" alt="*">
	<a href="/feeds.php">Новости</a>
</div>

<div class="list1">
	<img src="/design/images/page_forum_16_ns.png" alt="*"> 
	<a href="/kab/pth.php">Наблюдаемые темы</a>
</div>

<div class="list1">
	<img src="/design/images/gnome_dialog_question.png" alt="*">
	<a href="/ticket.php">Тикеты</a> | <a href="/all/info.php">FAQ</a>
</div>

<div class="menu2">
	Контакты
</div>

<div class="list1">
	<img src="/design/images/stop_2.png" alt="*">
	<a href="/kab/ignor_list">Игнор-лист</a>
</div>

<div class="menu2">
	Настройки
</div>

<div class="list1">
	<img src="/design/images/my-account.png" alt="*">
	<a href="/kab/lich">Личные данные</a>
</div>

<div class="list1">
	<img src="/design/images/css.png" alt="*">
	<a href="/kab/css.php">Дизайны / хранилище файлов</a>
</div>

<div class="list1">
	<img src="/design/images/057.png" alt="*">
	<a href="/photo.php">Аватар</a>
</div>

<div class="list1">
	<img src="/design/images/synaptic.png" alt="*">
	<a href="/kab/pass">Смена пароля</a>
</div>

<div class="list1">
	<img src="/design/images/log_in.png" alt="*">
	Авторизации: <a href="/kab/log.php">удачные</a> | <a href="/kab/popk.php">неудачные</a> | <a href="/kab/myper.php">переходы</a>
</div>

<div class="list1">
	<img src="/design/images/settings.png" alt="*">
	<a href="/kab/additional_settings">Дополнительные настройки</a>
</div>

<div class="menu2">
	Прочее
</div>

<div class="list1">
	<img src="/design/images/briefcase_16.png" alt="*">
	<a href="/port">Портфолио</a>
</div>

<div class="list1">
	<img src="/design/images/ok3.png" alt="*">
	<a href="/kab/kvest.php">Квесты</a>
</div>

<div class="list1">
	<img src="/design/images/network_service.png" alt="*">
	<a href="/services">Сервисы</a>
</div>

<div class="list1">
	<img src="/design/images/cod.png" alt="*">
	<a href="/all/bb.php">Бб-коды</a>
</div>

<div class="list1">
	<img src="/design/images/emoc.png" alt="*">
	<a href="/all/smiles_r.php">Смайлы</a>
</div>

<div class="list1">
	<img src="/design/images/chart.png" alt="*">
	Статистика: <a href="/kab/stat.php">моя</a> | <a href="/stat.php">Общая</a>
</div>

<div class="list1">
	<img src="/design/images/block_02.png" alt="*">
	<a href="/kab/akk.php">Заблокировать аккаунт</a>
</div>

<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>