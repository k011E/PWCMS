<?php
/*
* (c) CreaWap
* PWCMS
* Автор - TheAlex (vk.com/koiie)
* Сайт поддержки движка - pwcms.ru
* Группа движка в ВК - vk.com/pwcms
* Группа CreaWap в ВК - vk.com/crea_wap
*/
/**
* class Forum
*/
class Forum
{
	function __construct($id){
		global $user;
		if(isset($user['id'])){
			$this->updateInThema($id);
		}
	}

	function authorLastPost($id){
		
	}

	function inThemaNowCount($id){
		global $db;
		$time = time()-60;
		return $db->query("SELECT `id` FROM `forum_in_t` WHERE `id_thema`=".$id." AND `time`>".$time."")->num_rows;
	}

	function inThemaCount($id){
		global $db;
		return $db->query("SELECT `id` FROM `forum_in_t` WHERE `id_thema`=".$id."")->num_rows;
	}

	function checkUsInThema($id, $id_us){
		global $db;
		if($db->query("SELECT `id` FROM `forum_in_t` WHERE `id_us`=".$id_us." AND `id_thema`=".$id."")->num_rows==0){
			return false;
		}else{
			return true;
		}
	}

	function updateInThema($id){
		global $db, $user;
		if($this->checkUsInThema($id, $user['id'])){
			$db->query("UPDATE `forum_in_t` SET `time`=".time()." WHERE `id_us`=".$user['id']." AND `id_thema`=".$id."");
		}else{
			$db->query("INSERT INTO `forum_in_t` SET `id_us`=".$user['id'].", `id_thema`=".$id.", `time`=".time()."");
		}
	}

	function nameThema($id){
		global $db, $Filter;
		$thema = $db->query("SELECT `name` FROM `forum_t` WHERE `id`=".$id."")->fetch_assoc();
		return $Filter->output($thema['name']);
	}

	function checkThema($id){
		global $db;
		if($db->query("SELECT `id` FROM `forum_t` WHERE `id`=".$id."")->num_rows==0){
			return false;
		}else{
			return true;
		}
	}

	function typeThema($id){
		global $db;
		$thema = $db->query("SELECT `type` FROM `forum_t` WHERE `id`=".$id."")->fetch_assoc();
		return $thema['type'];
	}

	function  msgCount($id){
		global $db;
		return $db->query("SELECT `id` FROM `forum_p` WHERE `id_thema`=".$id."")->num_rows;
	}

	function msgPlusCount($id){
		global $db;
		return $db->query("SELECT `id` FROM `forum_rating_post` WHERE `id_post`=".$id." AND `type`=1")->num_rows;
	}

	function msgMinusCount($id){
		global $db;
		return $db->query("SELECT `id` FROM `forum_rating_post` WHERE `id_post`=".$id." AND `type`=2")->num_rows;
	}

	function msgMinus($id){
		echo '<a style="color: red" href="/forum/rating_post/'.$id.'/minus">'.$this->msgMinusCount($id).'</a>';
	}

	function msgPlus($id){
		echo '<a style="color: green" href="/forum/rating_post/'.$id.'/plus">'.$this->msgPlusCount($id).'</a>';
	}

	function msgUserCount($id){
		global $db;
		return $db->query("SELECT `id` FROM `forum_p` WHERE `id_us`=".$id."")->num_rows;
	}

	function typePost($id){
		global $db;
		$post = $db->query("SELECT `type` FROM `forum_p` WHERE `id`=".$id."")->fetch_assoc();
		return $post['type'];
	}

	function noAuthorPost($id){
		global $db, $user;
		$post = $db->query("SELECT `id_us` FROM `forum_p` WHERE `id`=".$id."")->fetch_assoc();
		if($post['id_us']!=$user['id']){
			return true;
		}else{
			return false;
		}
	}

	function checkSuccessVotePostUs($id){
		global $db, $user;
		$post = $db->query("SELECT `id_us` FROM `forum_p` WHERE `id`=".$id."")->fetch_assoc();
		$time = time()-3600;
		if($db->query("SELECT `id` FROM `forum_rating_post` WHERE `id_us`=".$user['id']." AND `id_author`=".$post['id_us']." AND `time`>".$time."")->num_rows!=0){
			return true;
		}else{
			return false;
		}
	}

	function checkVotePostUs($id){
		global $db, $user;
		if($db->query("SELECT `id` FROM `forum_rating_post` WHERE `id_post`=".$id." AND `id_us`=".$user['id']."")->num_rows!=0){
			return true;
		}else{
			return false;
		}
	}

	function checkSuccessVote($id){
		global $db, $user;
		if($this->msgUserCount($user['id'])>=50 AND $this->typePost($id)==0 AND $this->noAuthorPost($id) AND !$this->checkSuccessVotePostUs($id) AND !$this->checkVotePostUs($id)){
			return true;
		}else{
			return false;
		}
	}

	function checkPost($id){
		global $db;
		if($db->query("SELECT `id` FROM `forum_p` WHERE `id`=".$id."")->num_rows==0){
			return true;
		}else{
			return false;
		}
	}

	function viewVotePost($id){
		global $db;
		$vote = $db->query("SELECT `id_us`, `type` FROM `forum_rating_post` WHERE `id`=".$id."")->fetch_assoc();
		if($vote['type']==1){
			$rr = '<i style="color: green;">(<img src="/design/images/fa-thumbs-o-up.png">)</i>';
		}else{
			$rr = '<i style="color: red;">(<img src="/design/images/fa-thumbs-o-down.png">)</i>';
		}
		$r = ' '.nick($vote['id_us']).' '.$rr.'<br>';
		return $r;
	}

	function themsUsCount($id){
		global $db;
		return $db->query("SELECT `id` FROM `forum_t` WHERE `id_author`=".$id."")->num_rows;
	}

	function RThemaId($id_thema){
		/*
		* Метод возвращает id раздела по переданному ему id темы
		*/
		global $db;
		$thema = $db->query("SELECT `id_r` FROM `forum_t` WHERE `id`=".$id_thema."")->fetch_assoc();
		return $thema['id_r'];
	}

	function RName($id_r){
		/*
		* Метод возвращает название раздела по переданному ему ID разделаы
		*/
		global $db, $Filter;
		$r = $db->query("SELECT `name` FROM `forum_r` WHERE `id`=".$id_r."")->fetch_assoc();
		return $r['name'];
	}

	function ROut($id_r){
		/*
		* Метод выводит ссылку на раздел по переданному ему ID
		*/
		global $db, $Filter;
		$r = $db->query("SELECT * FROM `forum_r` WHERE `id`=".$id_r."")->fetch_assoc();
		echo '<a href="/forum/razd'.$r['id'].'">'.$Filter->output($r['name']).'</a>';
	}

	function PrThemaId($id_thema){
		/*
		* Метод возвращает ID подраздела по переданному ему ID темы
		*/
		global $db;
		$thema = $db->query("SELECT `id_pr` FROM `forum_t` WHERE `id`=".$id_thema."")->fetch_assoc();
		return $thema['id_pr'];
	}

	function PrName($id_pr){
		/*
		* Метод возвращает навзвание подраздела по переданному ему ID подраздела
		*/
		global $db, $Filter;
		$pr = $db->query("SELECT `name` FROM `forum_pr` WHERE `id`=".$id_pr."")->fetch_assoc();
		return $Filter->output($pr['name']);
	}

	function PrOut($id_pr){
		global $db, $Filter;
		$pr = $db->query("SELECT * FROM `forum_pr` WHERE `id`=".$id_pr."")->fetch_assoc();
		echo '<a href="/forum/'.$pr['r'].'/'.$pr['id'].'">'.$Filter->output($pr['name']).'</a>';
	}

}
?>