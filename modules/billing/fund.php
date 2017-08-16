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
	Пока что Вы можете пожертвовать средства только с личного внутреннего баланса <?=$_SERVER["HTTP_HOST"]?>!
	Полученные взносы будут расходоваться на развитие и процветание ресурса! <b>Всем спасибо!</b>
</div>
<?
if(isset($_GET['success'])){
	successNoExit('Благодарим за Вашу поддержку!');
}
if(isset($_GET['go'])){
	if(isset($_POST['ok'])){
		$_POST['summ'] = $Filter->input($Filter->clearInt($_POST['summ']));
		$_POST['password'] = crypt($_POST['password'], '$1$rasmusle$');
		if(!is_numeric($_POST['summ'])){
			errorNoExit('Введите число в поле ввода суммы!');
		}elseif(empty($_POST['summ'])){
			errorNoExit('Введите сумму!');
		}elseif($_POST['summ'] < 0){
			errorNoExit('Сумма должна быть положительным числом!');
		}elseif(empty($_POST['password'])){
			errorNoExit('Введите пароль!');
		}elseif($user['password']!=$_POST['password']){
			errorNoExit('Пароль не верен!');
		}elseif($user['money'] < $_POST['summ']){
			errorNoExit('У Вас недостаточно средств!');
		}else{
			$db->query("UPDATE `users` SET `money`=`money`-".$_POST['summ']." WHERE `id`=".$user['id']."");
			$db->query("INSERT INTO `billing_fund_log` SET `id_user`=".$user['id'].", `summ`=".$_POST['summ']."");
			header('location:/billing/fund/?success');
		}
	}
	?>
	<div class="lst">
		<form action="" method="POST">
			Сумма:<br>
			<input type="number" name="summ"><br>
			Ваш пароль:<br>
			<input type="password" name="password"><br>
			<input type="submit" name="ok" value="Перевести">
		</form>
	</div>
<?}else{?>
	<div class="list1">
		<img src="/design/images/money_safe.png"> <a href="?go">Пожертвовать</a>
	</div>
<?}?>
<div class="menu">
	Последние пожертвования
</div>
<?
$query = $db->query("SELECT * FROM `billing_fund_log` ORDER BY `id` DESC LIMIT 0, 10");
while ($us = $query->fetch_assoc()) {
	?>
	<div class="lst">
		<?=nick($us['id_user'])?> - <?=$us['summ']?>р.
	</div>
	<?
}
?>
<div class="navg">
	<img src="/design/images/home0.png">
	<a href="/billing">Моя панель</a>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
?>