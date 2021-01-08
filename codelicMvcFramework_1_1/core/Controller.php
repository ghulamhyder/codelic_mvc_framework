<?php
namespace app\core;
use app\core\Application;

class Controller {

	public string $layout='main';

	public function setLayOut($layout){
		$this->layout=$layout;
	}//end

	public function render($viewName,$udata=[]){
		return Application::$app->router->renderView($viewName,$udata);
	}//end
}


?>