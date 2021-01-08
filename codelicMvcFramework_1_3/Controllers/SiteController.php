<?php
namespace app\controllers;
use app\core\Application;
use app\core\Controller;

class SiteController extends Controller{


	public function home(){

		return $this->render('home');
	}
}



?>