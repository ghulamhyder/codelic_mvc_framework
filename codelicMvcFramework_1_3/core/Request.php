<?php
namespace app\core;



class Request {


	public function getPath(){

		/*$path=$_SERVER['REQUEST_URI'] ?? '/';

		$position=strpos($path, '?');

		if($position ===false){
			return $path;
		}

		return substr($path, 0,$position);*/
		if(isset($_GET['url'])){
			return strtolower(strip_tags($_GET['url']));
		} else {
			return '/';
		}
	}

	public function getMethod(){
		return strtolower($_SERVER['REQUEST_METHOD']) ?? false;
	}

	public function isPost(){

		return $this->getMethod()==='post' ?? false;
	}
	public function isGet(){
		
		return $this->getMethod()==='get' ?? false;
	}
	public function getBody(){

		$body=[];

		if($this->getMethod()==='get'){
			foreach ($_GET as $key => $val) {
				$body{$key}=filter_input(INPUT_GET, $key,FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		if($this->getMethod()==='post'){
			foreach ($_POST as $key => $val) {
				$body{$key}=filter_input(INPUT_POST, $key,FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		return $body;

	}
}




?>