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
* Upload Files Class
*/
class Upload
{
	public $dir;
	public $name;
	public $max;
	public $types;
	public $success;
	public $location;
	public $type;

	function __construct($dir, $name = 0, $type = 0, $max, $types, $success = 0, $location = 0)
	{
		$this->dir = $dir;
		$this->name = $name;
		$this->max = $max;
		$this->types = $types;
		$this->success = $success;
		$this->location = $location;
		$this->type = $type;
		$this->out();
	}

	function out()
	{
		if(isset($_POST['upload'])){
			$this->upload();
			$this->success();
		}

		?>
		<form action="" method="POST" enctype="multipart/form-data">
			<input type="file" name="file"><br>
			<input type="submit" name="upload" value="Загрузить">
		</form>
		<?
	}

	function upload()
	{
		$types = explode(',', $this->types);
		$upfiletype = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], ".") + 1);
		if(!file_exists($_FILES['file']['tmp_name'])){
			error('Выберите файл');
		}elseif($_FILES['file']['size'] > (1048576 * $this->max)){
			error('Максимальный размер загружаемого файла: '.$this->max.' мб.');
		}elseif(!in_array($upfiletype, $types)){
			error('Файл данного формата загружать запрещено.');
		}elseif(empty($this->name)){
			$this->name = passgen().'.'.$upfiletype;
		}else{
			if(!empty($this->type)){
				$upfiletype = $this->type;
			}
			$this->name = $this->name.'.'.$upfiletype;
		}
		copy($_FILES['file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"].'/files/'.$this->dir.'/'.$this->name);
		if(!empty($this->location)){
			header('location:/'.$this->location);
		}
	}

	function getName()
	{
		return $this->name;
	}

	function success()
	{
		if(!empty($this->success)){
			success($this->success);
		}else{
			return false;
		}
	}
}
?>