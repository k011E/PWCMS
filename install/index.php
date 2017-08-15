<?ob_start();?>
<!DOCTYPE html>
<?$version='PWCMS beta v 0.05'?>
<html>
	<head>
		<title>Установка <?=$version?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="/design/css/med/style.css">
		<link rel="stylesheet" type="text/css" href="/design/css/ef.css">
		<link rel="shortcut icon" href="/design/images/favicon.ico" type="image/x-icon">
    <meta charset="utf8">
		<style type="text/css">
			a.button1 {
				display: inline-block;
				font-family: arial,sans-serif;
				font-size: 11px;
				font-weight: bold;
				color: rgb(68,68,68);
				text-decoration: none;
				user-select: none;
				padding: .2em 1.2em;
				outline: none;
				border: 1px solid rgba(0,0,0,.1);
				border-radius: 2px;
				background: rgb(245,245,245) linear-gradient(#f4f4f4, #f1f1f1);
				transition: all .218s ease 0s;
			}
			a.button1:hover {
				color: rgb(24,24,24);
				border: 1px solid rgb(198,198,198);
				background: #f7f7f7 linear-gradient(#f7f7f7, #f1f1f1);
				box-shadow: 0 1px 2px rgba(0,0,0,.1);
			}
			a.button1:active {
				color: rgb(51,51,51);
				border: 1px solid rgb(204,204,204);
				background: rgb(238,238,238) linear-gradient(rgb(238,238,238), rgb(224,224,224));
				box-shadow: 0 1px 2px rgba(0,0,0,.1) inset;
			}
		</style>
	</head>

	<body>
		<?php
		error_reporting(0);
		switch ($_GET['step']) {
			case '2':
				?>
				<div class="menu">
					Подключение к БД
				</div>
				<div class="list1">
					<?if(isset($_POST['connect'])){
						$db = new mysqli($_POST['host'], $_POST['user'], $_POST['password'], $_POST['name']);
						if($db->connect_errno){
							?>
								<b><font color="red">Ошибка подключения к БД: <?=$db->connect_error?></font></b>
							<?
						}else{
							
$string_query = "

--
-- Структура таблицы `auth_fail`
--

CREATE TABLE `auth_fail` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `ua` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_success`
--

CREATE TABLE `auth_success` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `ua` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `forum_edit_p`
--

CREATE TABLE `forum_edit_p` (
  `id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `forum_in_t`
--

CREATE TABLE `forum_in_t` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `id_thema` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `forum_p`
--

CREATE TABLE `forum_p` (
  `id` int(11) NOT NULL,
  `id_r` int(11) NOT NULL,
  `id_pr` int(11) NOT NULL,
  `msg` text NOT NULL,
  `type` int(1) NOT NULL,
  `id_us` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `id_thema` int(11) NOT NULL,
  `cit` int(11) NOT NULL DEFAULT '0',
  `del_us` int(11) NOT NULL,
  `rec_us` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `forum_podp`
--

CREATE TABLE `forum_podp` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `id_thema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `forum_pr`
--

CREATE TABLE `forum_pr` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rules` text NOT NULL,
  `r` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `forum_r`
--

CREATE TABLE `forum_r` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `forum_rating_post`
--

CREATE TABLE `forum_rating_post` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `id_author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `forum_t`
--

CREATE TABLE `forum_t` (
  `id` int(11) NOT NULL,
  `id_r` int(11) NOT NULL,
  `id_pr` int(11) NOT NULL,
  `id_author` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `type` int(1) NOT NULL,
  `last` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `gazeta_articles`
--

CREATE TABLE `gazeta_articles` (
  `id` int(11) NOT NULL,
  `id_r` int(11) NOT NULL,
  `name` text NOT NULL,
  `text` text NOT NULL,
  `id_author` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `gazeta_comm`
--

CREATE TABLE `gazeta_comm` (
  `id` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `text` text NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `gazeta_sections`
--

CREATE TABLE `gazeta_sections` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `history_nick`
--

CREATE TABLE `history_nick` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `id_adm` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `old` varchar(255) NOT NULL,
  `new` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `page` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mail_contacts`
--

CREATE TABLE `mail_contacts` (
  `id` int(11) NOT NULL,
  `id_by` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `last` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mail_favorite`
--

CREATE TABLE `mail_favorite` (
  `id` int(11) NOT NULL,
  `id_who` int(11) NOT NULL,
  `id_whom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mail_ignor`
--

CREATE TABLE `mail_ignor` (
  `id` int(11) NOT NULL,
  `who` int(11) NOT NULL,
  `whom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mail_messages`
--

CREATE TABLE `mail_messages` (
  `id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `id_by` int(11) NOT NULL,
  `text` text NOT NULL,
  `read` int(1) NOT NULL DEFAULT '0',
  `id_contact` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `medals`
--

CREATE TABLE `medals` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `id_adm` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `for_what` text NOT NULL,
  `medal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `id_us` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `news_comm`
--

CREATE TABLE `news_comm` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `id_news` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `text` text NOT NULL,
  `time` int(11) NOT NULL,
  `read` int(1) NOT NULL DEFAULT '0',
  `section` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `notifications_sections`
--

CREATE TABLE `notifications_sections` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `repass`
--

CREATE TABLE `repass` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `tocken` varchar(32) NOT NULL,
  `activation` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `screens`
--

CREATE TABLE `screens` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `senks`
--

CREATE TABLE `senks` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `id_sender` int(11) NOT NULL,
  `text` text NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `smiles`
--

CREATE TABLE `smiles` (
  `id` int(11) NOT NULL,
  `r` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `smiles_r`
--

CREATE TABLE `smiles_r` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `subscribes`
--

CREATE TABLE `subscribes` (
  `id` int(11) NOT NULL,
  `subscriber` int(11) NOT NULL,
  `to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `system_info`
--

CREATE TABLE `system_info` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `licension` text NOT NULL,
  `version` float NOT NULL,
  `version_build` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `system_info`
--

INSERT INTO `system_info` (`id`, `name`, `licension`, `version`, `version_build`) VALUES
(1, 'PWCMS beta', 'Free', 0.05, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nick` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sex` varchar(3) NOT NULL,
  `email` varchar(255) NOT NULL,
  `time_reg` int(11) NOT NULL,
  `tocken` varchar(32) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  `online` int(11) NOT NULL,
  `where` varchar(120) NOT NULL,
  `rating` float NOT NULL DEFAULT '0',
  `time_online` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL,
  `birth` varchar(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `info` varchar(255) NOT NULL,
  `icq` int(11) NOT NULL,
  `scam` int(1) NOT NULL DEFAULT '0',
  `block` text NOT NULL,
  `ip` text NOT NULL,
  `ua` text NOT NULL,
  `journalist` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users_settings`
--

CREATE TABLE `users_settings` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `max_p` int(11) NOT NULL DEFAULT '10',
  `homet` int(5) NOT NULL DEFAULT '5',
  `homef` int(1) NOT NULL DEFAULT '3',
  `homec` int(1) NOT NULL DEFAULT '3',
  `top_home` int(1) NOT NULL DEFAULT '1',
  `comm_home` int(1) NOT NULL DEFAULT '1',
  `files_forum` int(1) NOT NULL DEFAULT '1',
  `ads` int(1) NOT NULL DEFAULT '1',
  `smiles` int(1) NOT NULL DEFAULT '1',
  `view_mail` int(1) NOT NULL DEFAULT '1',
  `ajax` int(1) NOT NULL DEFAULT '0',
  `files_mail` int(1) NOT NULL DEFAULT '1',
  `normal_notifications` int(1) NOT NULL DEFAULT '0',
  `up_panel` int(1) NOT NULL DEFAULT '1',
  `feed_ank` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_fail`
--
ALTER TABLE `auth_fail`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `auth_success`
--
ALTER TABLE `auth_success`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `forum_edit_p`
--
ALTER TABLE `forum_edit_p`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `forum_in_t`
--
ALTER TABLE `forum_in_t`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `forum_p`
--
ALTER TABLE `forum_p`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `forum_podp`
--
ALTER TABLE `forum_podp`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `forum_pr`
--
ALTER TABLE `forum_pr`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `forum_r`
--
ALTER TABLE `forum_r`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `forum_rating_post`
--
ALTER TABLE `forum_rating_post`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `forum_t`
--
ALTER TABLE `forum_t`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `gazeta_articles`
--
ALTER TABLE `gazeta_articles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `gazeta_comm`
--
ALTER TABLE `gazeta_comm`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `gazeta_sections`
--
ALTER TABLE `gazeta_sections`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `history_nick`
--
ALTER TABLE `history_nick`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mail_contacts`
--
ALTER TABLE `mail_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mail_favorite`
--
ALTER TABLE `mail_favorite`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mail_ignor`
--
ALTER TABLE `mail_ignor`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mail_messages`
--
ALTER TABLE `mail_messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `medals`
--
ALTER TABLE `medals`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news_comm`
--
ALTER TABLE `news_comm`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `notifications_sections`
--
ALTER TABLE `notifications_sections`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `repass`
--
ALTER TABLE `repass`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `screens`
--
ALTER TABLE `screens`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `senks`
--
ALTER TABLE `senks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `smiles`
--
ALTER TABLE `smiles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `smiles_r`
--
ALTER TABLE `smiles_r`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subscribes`
--
ALTER TABLE `subscribes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_settings`
--
ALTER TABLE `users_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `auth_success`
--
ALTER TABLE `auth_success`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `forum_edit_p`
--
ALTER TABLE `forum_edit_p`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `forum_in_t`
--
ALTER TABLE `forum_in_t`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `forum_p`
--
ALTER TABLE `forum_p`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `forum_podp`
--
ALTER TABLE `forum_podp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `forum_pr`
--
ALTER TABLE `forum_pr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `forum_r`
--
ALTER TABLE `forum_r`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `forum_rating_post`
--
ALTER TABLE `forum_rating_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `forum_t`
--
ALTER TABLE `forum_t`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `gazeta_articles`
--
ALTER TABLE `gazeta_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `gazeta_comm`
--
ALTER TABLE `gazeta_comm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `gazeta_sections`
--
ALTER TABLE `gazeta_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `history_nick`
--
ALTER TABLE `history_nick`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `mail_contacts`
--
ALTER TABLE `mail_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `mail_favorite`
--
ALTER TABLE `mail_favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `mail_ignor`
--
ALTER TABLE `mail_ignor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `mail_messages`
--
ALTER TABLE `mail_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `medals`
--
ALTER TABLE `medals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `news_comm`
--
ALTER TABLE `news_comm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `notifications_sections`
--
ALTER TABLE `notifications_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `repass`
--
ALTER TABLE `repass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `screens`
--
ALTER TABLE `screens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `senks`
--
ALTER TABLE `senks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `smiles`
--
ALTER TABLE `smiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `smiles_r`
--
ALTER TABLE `smiles_r`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `subscribes`
--
ALTER TABLE `subscribes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users_settings`
--
ALTER TABLE `users_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
";
$db->multi_query($string_query) or die($db->error);
							$text = '<?php
$db = new mysqli("'.$_POST['host'].'", "'.$_POST['user'].'", "'.$_POST['password'].'", "'.$_POST['name'].'");
if($db->connect_errno){
	die("Ошибка подключения к БД: ".$db->connect_error);
}
$db->set_charset("utf8");
?>';
							$file=fopen('../system/db.php','w+');
							fwrite($file,$text);
							fclose($file);
							?>
								БД была подключена, таблицы загружены, файл подключения к БД создан.<br>
								<center><a href="?step=3"><input type="submit" value="Продолжить"></a></center>
								<div class="menu"><center><?=$version?></center></div></div>
							<?
							exit();
						}
					}?>
					<form action="" method="POST">
						Хост (сервер) MySQL:<br>
						<input type="text" name="host"><br>
						Пользователь:<br>
						<input type="text" name="user"><br>
						Пароль:<br>
						<input type="password" name="password"><br>
						Название БД:<br>
						<input type="text" name="name"><br>
						<input type="submit" name="connect" value="Подключиться">
					</form>
				</div>
				<?
			break;

			case '3':
			include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
				?>
				<div class="menu">
					Создание аккаунта администратора
				</div>
				<div class="list1">
				<?if(isset($_POST['reg'])){
					if(empty($_POST['nick']) OR empty($_POST['email']) OR empty($_POST['pass'])){
						echo "<b><font color='red'>Заполните все данные!</font></b>";
					}else{
						$tocken = md5(rand(0, 10)+time()+rand(0, 100));
						$db->query("INSERT INTO `users` SET `nick`='".$_POST['nick']."', `password`='".crypt($_POST['pass'], '$1$rasmusle$')."', `email`='".$_POST['email']."', `admin`='4', `tocken`='".$tocken."'");
						$id = $db->insert_id;
						setcookie("tocken", $tocken, time()+60*60*24*31*12, "/");
						$db->query("INSERT INTO `users_settings` SET `id_us`='1', `max_p`='10', `homet`='5', `homef`='3', `homec`='3', `top_home`='1', `comm_home`='1', `files_forum`='0', `ads`='1', `smiles`='1', `view_mail`='1', `ajax`='1', `files_mail`='1', `normal_notifications`='0', `up_panel`='1', `feed_ank`='1'");
						file_get_contents("http://pwcms.ru/api/installed.php?site=".$_SERVER["HTTP_HOST"]."");
						header('location:/install/?step=4');
					}
				}?>
					<form action="" method="POST">
						Логин:<br>
						<input type="text" name="nick"><br>
						Пароль:<br>
						<input type="password" name="pass"><br>
						E-Mail:<br>
						<input type="email" name="email"><br>
						<input type="submit" name="reg" value="Зарегистрироваться">
					</form>
				</div>
				<?
			break;

			case '4':
				?>
				<div class="menu">
					Завершение установки
				</div>
				<div class="list1">
					Что дальше?
					Ваш сайт полностью установлен. Для безопасности рекомундуем удалить папку install из корневой директори сайта
					<center><a href="/"><input type="submit" value="Начать использование"></a></center>
				</div>
				<?
			break;
			
			default:
				?>
				<div class="menu">
					Начало установки
				</div>
				<div class="list1">
					Вы устанавливаете <b><?=$version?></b>.<br>
					<b>Разработчик:</b><br>
					Александр Каплин (TheAlex) (<a href="http://vk.com/koiie">VK</a>)<br>
					<b>Группа движка ВКонтакте:</b> <a href="http://vk.com/pwcms.ru">ссылка</a><br>
					Все права принадлежат CreaWap (<a href="http://vk.com/crea_wap">VK</a>)<br>
					Сайт поддержки PWCMS: <a href="http://pwcms.ru">ссылка</a>
					<b>Соглашение:</b><br>
					Нажимая кнопку продолжить Вы соглашаетесь с условиями представлеными ниже:<br>
					1. Запрещено снимать копирайт разработчика в коде<br>
					2. Запрещено продавать движок/части движка<br>
					3. Запрещено представляться автором движка<br>
					4. При создании модификаций на основе движка, в его описании должно быть указано, что Ваша модификация построена на основе PWCMS, а также иметь ссылку на сайт поддержки PWCMS<br>
					<center><a href="?step=2"><input type="submit" value="Продолжить"></a></center>
				</div>
				<?
			break;
		}
		?>
		<div class="menu"><center><?=$version?></center></div>
	</body>
</html>