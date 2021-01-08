<?php
namespace app\controllers;
use app\core\Controller;


class SiteController extends Controller{

	public function home(){
		$data=[
			'title'=>'Codelic code programme'
		];

		return $this->render('home',$data);
	}

	public function handleContact(){
		return "handle contact";
	}
}



?>