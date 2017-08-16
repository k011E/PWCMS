<?
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
function __autoload($class_name) {
    include $_SERVER["DOCUMENT_ROOT"].'/system/class/'.$class_name . '.php';
}
$UserSettings = new UserSettings($user['id']);

function error($str){
	global $db;
	echo '<div class="lst"><b>'.$str.'</b></div>';
	include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
	exit();
}

function errorNoExit($str = 'Ошибка...'){
	echo '<div class="lst"><b>'.$str.'</b></div>';
}

function success($str){
	global $db;
	echo '<div class="lst">'.$str.'</div>';
	include_once($_SERVER["DOCUMENT_ROOT"].'/design/foot.php');
	exit();
}

function successNoExit($str){
	echo '<div class="lst">'.$str.'</div>';
}

function mode($mode){
	global $user;
	if($mode == 'user'){
		if(!isset($user['id'])){
			include_once($_SERVER["DOCUMENT_ROOT"].'/design/head.php');
			error('Данный модуль закрыт от гостей. Авторизуйтесь.');
		}
	}elseif($mode == 'guest'){
		if(isset($user['id'])){
			error('Данный модуль закрыт для авторизованных пользователей.');
		}
	}
}

function admin($admin){
	global $user;
	if($user['admin']<$admin){
		error('У вас нет прав для просмотра данной страницы.');
	}
}

function nick($id){

	global $db, $Filter;
	if (is_array($id)) { 
    	$id = $id[1]; 
    } 
    else { 
    	$id = $id; 
    }
    if($id == 'this'){
    	global $user;
    	$id = $user['id'];
    }
	$query = $db->query("SELECT * FROM `users` WHERE `id`=".$id."");
	if($query->num_rows==0){
		$out = 'Удалён';
	}else{
		$us = $query->fetch_assoc();
		if(!empty($us['icon'])){
			$icon = '<img src="/files/icon/'.$us['id'].'.png" style="width: 16px; height: 16px;"> ';
		}else{
			if($us['online']>time()-3600){
				if($us['sex']='Муж'){
					$icon = '<img src="/design/images/mon.png"> ';
				}else{
					$icon = '<img src="/design/images/jon.png"> ';
				}
			}else{
				if($us['sex']=='Муж'){
					$icon = '<img src="/design/images/mof.png"> ';
				}else{
					$icon = '<img src="/design/images/jof.png"> ';
				}
			}
		}
	}
	$nick = '<a href="/us'.$us['id'].'" style="text-decoration: none; color: black;"><b>'.$Filter->output($us['nick']).'</b></a>';
	if($us['admin'] == 1){
		$st = 'мд';
	}elseif($us['admin'] == 2){
		$st = 'адм';
	}elseif($us['admin'] == 3){
		$st = 'cт. адм';
	}elseif($us['admin'] == 4){
		$st = 'соз';
	}
	if($us['admin']>=1){
		$nick .= " <font color='green'>[$st]</font>";
	}

	if($us['scam']==1){
		$nick .= " [<font color='red'><b>мошенник</b></font>]";
	}

	$out = $icon.$nick;
	return $out;
}

function endi ($count, $msg = array ())
{
	$count = (int) $count;
	$max = $count % 100;
	$min = $count % 10;

	if ($max > 10 && $max < 20) {
		return $count . ' ' . $msg[2];
	}

	if ($min > 1  && $min < 5 ) {
		return $count . ' ' . $msg[1];
	}

	if ($min == 1) {
		return $count . ' ' . $msg[0];
	}

	return $count . ' ' . $msg[2];
}

function datef ($time)
{
	$t = time ();
	if (($t - $time) <= 60) {
		$out .= endi ((time () - $time), array (
												'секунду',
												'секунды',
												'секунд'
												));
		$out .= ' назад';

	}elseif (($t - $time) <= 3600) {
		$out .= endi ((($t - $time)/60), array (
												'минуту',
												'минуты',
												'минут'
												));
		$out .= ' назад';

	}else{
		$timesp = date("j M Y  в H:i", $time);
		$timesp = str_replace (date ("j M Y", $t), 'Сегодня', $timesp);
		$timesp = str_replace (date ("j M Y", strtotime ("-1 day")), 'Вчера', $timesp);
		$timesp = strtr ($timesp, array (
										'Jan' => 'Января',
										'Feb' => 'Февраля',
										'Mar' => 'Марта',
										'May' => 'Мая',
										'Apr' => 'Апреля',
										'Jun' => 'Июня',
										'Jul' => 'Июля',
										'Aug' => 'Августа',
										'Sep' => 'Сентября',
										'Oct' => 'Октября',
										'Nov' => 'Ноября',
										'Dec' => 'Декабря'
										));

		$out .= $timesp;
	}
	return $out;
}

function timef ($time)
{
	$days    = floor ( $time / 86400 );
	$hours   = floor (($time / 3600 ) - ( $days * 24 ) );
	$minutes = floor (($time - ( $hours * 3600 ) - ( $days * 86400 ) ) / 60 );
	$seconds = floor ( $time - ( ( $minutes * 60 ) + ( $hours * 3600 ) + ( $days * 86400) ) ); 

	if ($days != 0) {
		$out .= endi ($days, array (
									'день',
									'дня',
									'дней'
									));
		if ($hours!=0 || $minutes!=0 || $seconds!=0) {
			$out .= ', ';
		}
	}
	if ($hours != 0) {
		$out .= endi ($hours, array (
									'час',
									'часа',
									'часов'
									));
		if ($minutes!=0 || $seconds!=0) {
			$out .= ', ';
		}
	}
	if ($minutes != 0) {
		$out .= endi ($minutes, array(
										'минуту',
										'минуты',
										'минут'
										));
		if ($seconds!=0) {
			$out .= ', ';
		}
	}
	if ($seconds != 0) {
		$out .= endi ($seconds, array (
										'секунду',
										'секунды',
										'секунд'
		));
	}
	return $out;
}

function where($id) {
	global $db;
	$id = abs(intval($id));
	$us = $db->query("SELECT * FROM `users` WHERE `id`='".$id."'")->fetch_assoc();
	switch ($us['where']) {
		case 'index':
			$where = 'На главной';
			break;
		
		case 'admin':
			$where = 'В админ-панеле';
			break;

		case 'kab':
			$where = 'В кабинете';
			break;

		case 'news':
			$where = 'В новостях';
			break;

		case 'online':
			$where = 'Кто онлайн?';
			break;

		case 'all_masters':
			$where = 'Список мастеров';
			break;

		case 'page_user':
			$where = 'Страница пользователя';
			break;

		case 'forum':
			$where = 'На форуме';
			break;

		case 'actions':
			$where = 'Оповещения';
			break;

		case 'senks':
			$where = 'Благодарности';
			break;

		case 'gazeta':
			$where = 'Газета';
			break;

		case 'mail':
			$where = 'Почта';
			break;

		case 'billing';
			$where = 'Биллинг';
			break;

		default:
			$where = 'Неизвестно';
			break;

		
	}
	return $where;
}

function passgen($count = 8)
{
	$symbols = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

		for ($i = 0; $i < $count; $i ++) {
			$out .= $symbols [ mt_rand (0, 61) ];
		}
        
	return  $out;
        
}

function bb ($string) 
{     
global $db, $UserSettings;         
        $codes = array ( 
                // ссылка 
                '/\[url=(.+)\](.+)\[\/url\]/is'        =>'<a href="\1">\2</a>', 
                '/\[url](.+)\[\/url\]/isU'             =>'<a href="\1">\1</a>', 
				//Картинка
				'/\[img](.+)\[\/img\]/isU'             =>'<a href="\1"><img src="\1" style="max-width: 300px; max-height: 500px;"></a>', 
                // наклонный текст 
                '/\[i\](.+)\[\/i\]/isU'                => '<i>\1</i>', 
                // жирный текст 
                '/\[b\](.+)\[\/b\]/isU'                => '<b>\1</b>', 
                // подчеркнутый текст 
                '/\[u\](.+)\[\/u\]/isU'                => '<u>\1</u>', 
                // Пунктирная линия
                '/\[ut\](.+)\[\/ut\]/i'			   	   => '<span style="border-bottom: 1px dotted;">\1</span>',
                // мелкий текст 
                '/\[small\](.+)\[\/small\]/i'          => '<span style="font-size:10px;">\1</span>', 
                // пунктирная табличка
                '/\[das\](.+)\[\/das\]/i'			   => '<span style="border:1px dashed;">\1</span>',
                // бегущая строка
                '/\[marq\](.+)\[\/marq\]/i'			   => '<marquee>\1</marquee>',
                // 	центрирование
                '/\[c\](.+)\[\/c\]/i'				   => '<center>\1</center>',
                // расположение справа
                '/\[right\](.+)\[\/right\]/i'		   => '<span style="text-align: right; display: block;">\1</span>',
                // табличка
                '/\[sol\](.+)\[\/sol\]/i'			   => '<span style="border:1px solid;">\1</span>',
                // зачёркнутый текст
                '/\[ex\](.+)\[\/ex\]/i'				   => '<span style="text-decoration:line-through;">\1</span>',
                // пунктирная табличка
                '/\[dot\](.+)\[\/dot\]/i'			   => '<span style="border:1px dotted;">\1</span>',
                // двойная табличка
                '/\[dou\](.+)\[\/dou\]/i'			   => '<span style="border:3px double black;">\1</span>',
                // большой текст 
                '/\[big\](.+)\[\/big\]/i'              => '<span style="font-size:large;">\1</span>', 
                // красный 
                '/\[red\](.+)\[\/red\]/i'              => '<span style="color:red;">\1</span>',
                // белый
                '/\[white\](.+)\[\/white\]/i'		   => '<span style="color: white;">\1</span>',
                // зеленый 
                '/\[green\](.+)\[\/green\]/i'          => '<span style="color:green;">\1</span>', 
                // синий 
                '/\[blue\](.+)\[\/blue\]/i'            => '<span style="color:blue;">\1</span>', 
                // выделение кода 
                '/\[code\](.+)\[\/code\]/is'           => '<code>\1</code>', 
                // рейтинг
                '/\[rating=([0-9\.]{1,})\](.*)\[\/rating\]/ies'=> 'hide_rated ("\1", "\2")',
                //wmid
                '/\[wm\](.*)\[\/wm\]/is'			   => '<a href="http://passport.webmoney.ru/asp/CertView.asp?wmid=\1">\1</a> (<img src="http://bl.wmtransfer.com/img/bl/\1?w=45&h=18&bg=0XDBE2E9">)'
        ); 
         

        $string = preg_replace (array_keys($codes), array_values ($codes), $string);
        $string = str_replace ("\r\n", "<br/>", $string); 
        $string = str_replace ("[br]", "<br/>", $string); 

        // us{[int]} // вывод пользователя 
        $string = preg_replace_callback ('/us{(\d*)}/', 'nick', $string); 
        $string = preg_replace_callback ('/us{this}/', 'nick', $string); 
        // file{[int]} // вывод файла 
       // $string = preg_replace_callback ('/file{(\d*)}/', 'fname', $string); 
        // topic{[int]}
        //$string = preg_replace_callback ('/topic{(\d*)}/', 'tname', $string); 
        // [php][string][/php] // выделение php кода 
        $string = preg_replace_callback ('/\[php\](.+)\[\/php\]/i', 'highlight_code', $string); 
         
        if($UserSettings->getSmile()==1){
	        $sm = $db->query("SELECT * FROM `smiles`");
	        while ($smile = $sm->fetch_assoc()) { 
	                $string = str_replace($smile['name'], '<img src="/files/smiles/'.$smile['file'].'">', $string);
	        }
	    }

        return $string; 

} 

function highlight_code($matches) 
{ 


        // если callback функция 
        if (is_array($matches)) { 
                $code = $matches[1]; 
        } 
        else { 
                $code = $matches; 
        } 
                 
        // перепреобразование кода 
        $code = strtr ($code, array ( 
                '&lt;'   => '<', 
                '&gt;'   => '>', 
                '&amp;'  => '&', 
                '&quot;' => '"', 
                '&#36;'  => '$', 
                '&#37;'  => '%',  
                '&#39;'  => "'", 
                '&#92;'  => '\\', 
                '&#94;'  => '^', 
                '&#96;'  => '`', 
                '&#124;' => '|' 
        )); 
         
        // новая строка 
        $code = strtr ($code, array ( 
                "<br/>" => "\r\n", 
                "\\"    => "" 
        )); 
         
        $code = highlight_string($code, true); 

        return $code; 
     
} 

function hide_rated($rating = 0, $matches) 
{ 
         
        global $user; 
         
        // если callback функция 
        if (is_array($matches)) { 
                $string = $matches[1]; 
        } 
        else { 
                $string = $matches; 
        } 
         
         
        if ($user['rating']>=$rating) { 
                return $string; 
        } 
        else { 
                return '<div class="error">Для просмотра этого блока необходимо набрать <b>' . $rating . '</b> рейтинга</div>'; 
        } 
}
function imgT($id){
	$id = abs(intval($id));
	global $db;
	$query = $db->query("SELECT * FROM `forum_t` WHERE `id`=".$id."");
	$thema = $query->fetch_assoc();
	if($thema['type']==1){
		$icon = 'deleted.png';
	}elseif ($thema['type']==2) {
		$icon = 'theme.png';
	}elseif($thema['type']==3){
		$icon = 'closed.png';
	}elseif($thema['type']==4){
		$icon = 'prikrep.png';
	}elseif($query->num_rows==0){
		$icon = 'deleted.png';
	}
	echo "<img src='/design/images/".$icon."'>";
} 

function lstPage($id, $mode = 0){
	$id = abs(intval($id));
	global $db, $Filter;
	$tl = $db->query("SELECT `id` FROM `forum_p` WHERE `id_thema`=".$id."")->num_rows;
	$t1 = $tl/10;
	$t2 = abs(intval($tl/10));
	if($t1>$t2){
		$pg = $t2+1;
	}else{
		$pg = $t1;
	}
	if(empty($mode)){
		echo "<a href='/forum/thema$id/page$pg'>></a>";
	}elseif($mode==2){
		$thema = $db->query("SELECT `name` FROM `forum_t` WHERE `id`=".$id."")->fetch_assoc();
		return '[url=http://'.$_SERVER["HTTP_HOST"].'/forum/thema'.$id.'/page'.$pg.']'.$Filter->output($thema['name']).'[/url]';
	}else{
		return $pg;
	}
}

function countPosts($id){
	$id = abs(intval($id));
	global $db;
	return $db->query("SELECT `id` FROM `forum_p` WHERE `id_thema`=$id")->num_rows;
}

function authorTopic($id){
	$id = abs(intval($id));
	global $db;
	$topic = $db->query("SELECT `id_author` FROM `forum_t` WHERE `id`=$id")->fetch_assoc();
	return nick($topic['id_author']);
}

function authorLastPost($id){
	$id = abs(intval($id));
	global $db;
	$lastPost = $db->query("SELECT `id_us` FROM `forum_p` WHERE `id_thema`=$id ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
	return nick($lastPost['id_us']);
}

function dateLastPost($id){
	$id = abs(intval($id));
	global $db;
	$lastPost = $db->query("SELECT `time` FROM `forum_p` WHERE `id_thema`=$id ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
	return datef($lastPost['time']);
}

function trans($t){
	$a = array('_','YA','Ya','ya','yee','YO','yo','Yo','ZH','zh','Zh','Z','z','CH','ch','Ch','SH','sh','Sh','YE','ye','Ye','YU','yu','Yu','JA','ja','Ja','A','a','B','b','V','v','G','g','D','d','E','e','I','i','J','j','K','k','L','l','M','m','N','n','O','o','P','p','R','r','S','s','T','t','U','u','F','f','H','h','W','w','x','q','Y','y','C','c','!');
	$b = array(' ','Я','Я','я','ые','Ё','ё','Ё','Ж','ж','Ж','З','з','Ч','ч','Ch','Ш','ш','Ш','Э','э','Э','Ю','ю','Ю','Я','я','Я','А','а','Б','б','В','в','Г','г','Д','д','Е','е','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о','П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Щ','щ','ъ','ь','Ы','ы','Ц','ц','');
	return str_replace($b,$a,$t);
}

function delS($text)
{
	$text=str_replace('&','', $text);
	$text=str_replace('$','', $text);
	$text=str_replace('>','', $text);
	$text=str_replace('<','', $text);
	$text=str_replace('~','', $text);
	$text=str_replace('`','', $text);
	$text=str_replace('#','', $text);
	$text=str_replace('*','', $text);
	return $text;
}

function fileSizeOut($file){

	if(file_exists($file)){
		return;
	}

	$size = filesize($file);
}

function user_exist($id){
	global $db;
	if($db->query("SELECT `id` FROM `users` WHERE `id`=".$id."")->num_rows==0){
		return false;
	}else{
		return true;
	}
}

function new_bb($mes){
	$mes = stripslashes($mes);
    $mes = preg_replace('#\[cit\](.*?)\[/cit\]#si', '<div class="cit">\1</div>', $mes);
    $mes = preg_replace('#\[b\](.*?)\[/b\]#si', '<span style="font-weight: bold;"> \1 </span>', $mes);
    $mes = preg_replace('/\[url\s?=\s?([\'"]?)(?:http:\/\/)?(.*?)\1\](.*?)\[\/url\]/', ' <a href="http://$2"> $3 </a> ', $mes);
    $mes = preg_replace('#\[black\](.*?)\[\/black\]#si', '<span style="color:#000000;">\1</span>', $mes);
    $mes = preg_replace('#\[i\](.*?)\[\/i\]#si', '<i>\1</i>', $mes);
    $mes = preg_replace('#\[u\](.*?)\[\/u\]#si', '<u>\1</u>', $mes);
    $mes = preg_replace('#\[s\](.*?)\[\/s\]#si', '<s>\1</s>', $mes);
    $mes = preg_replace('#\[red\](.*?)\[\/red\]#si', '<span style="color: red">\1</span>', $mes);
    $mes = preg_replace('#\[green\](.*?)\[\/green\]#si', '<span style="color: green">\1</span>', $mes);
    $mes = preg_replace('#\[blue\](.*?)\[\/blue\]#si', '<span style="color: blue">\1</span>', $mes);
    $mes = preg_replace("~(^|\s|-|:| |\()(http(s?)://|(www\.))((\S{25})(\S{5,})(\S{15})([^\<\s.,>)\];'\"!?]))~i", "\\1<a href=\"http\\3://\\4\\5\">\\4\\6...\\8\\9</a>", $mes);
    $mes = preg_replace("~(^|\s|-|:|\(| |\xAB)(http(s?)://|(www\.))((\S+)([^\<\s.,>)\];'\"!?]))~i", "\\1<a href=\"http\\3://\\4\\5\">\\4\\5</a>", $mes);

    return $mes;
}
?>