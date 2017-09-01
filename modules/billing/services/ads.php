<?php
$title = $menu = 'Моя панель';
$where = 'billing';
include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
mode('user');
$billing_config = $db->query("SELECT * FROM `billing_config_prices` WHERE `id`=1")->fetch_assoc();
?>
<div class="list1">
	<b>Запрещается размещать рекламные ссылки ведущие на сайты таких тематик как: Педофилия, суицuд, зоофилию, живодёрство, все виды наркомании и пропаганды наркотиков и подобного. В названии ссылки запрещается использование нецензурной лексики, ругательной брани, подстрекательство и расжигание конфликтов!</b><br>
	<font color="red">За нарушение вышесказанного - удаление площадки без возврата средств.</font><br> 
	<b>Стоимость рекламы:</b><br>
	* Главная страница: <?=$billing_config['ads_home']?>р/сутки<br>
	* Все страницы: <?=$billing_config['ads_all']?>р/сутки<br>
	* Низ все страницы: <?=$billing_config['ads_all_down']?> руб/сутки<br>
	<form action="" method="POST">
		Название ссылки:<br>
		<input type="text" name="name"><br>
		Адрес: (без http://):<br>
		<input type="text" name="url"><br>
		Время:<br>
		<input type="text" name="time">суток<br>
		Где:<br>
		<select name="type">
			<option value="1">Верх главной (<?=$billing_config['ads_home']?> руб/сутки )</option>
			<option value="2">Верх всех страниц (<?=$billing_config['ads_all']?> руб/сутки)</option>
			<option value="3">Низ всех страниц (<?=$billing_config['ads_all_down']?> руб/сутки)</option>
		</select><br>
		Цвет ссылки: <small>(+<?=$billing_config['ads_color']?>р/сутки)</small><br>
		<input type="text" name="color"><br>
		<small>Пример: #FF0000</small><br>
		<input type="radio" name="fat" value="1">жирность <small>(+<?=$billing_config['ads_fat']?>р/сутки)</small><br>
		<input type="radio" name="emphasis" value="1">подчёркнутость <small>(+<?=$billing_config['ads_emphasis']?>р/сутки)</small><br>
		<input type="submit" name="ok" value="Добавить">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>