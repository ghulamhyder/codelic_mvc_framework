<?php
namespace app\core;
use app\core\middlewares\BaseMiddleware;

Abstract class Controller{

		public string $layout="main";
		protected array $middlewares=[];

		public string $action='';


		public function setLayout(string $layout){
			$this->layout=$layout;
		}

	public function render($viewName,$data=[]){

		return Application::$app->router->renderView($viewName,$data);

	}


	public function registerMiddleware(BaseMiddleware $middleware){

		$this->middlewares[]=$middleware;

	}

	public function getMiddlewaresArr(){

		return $this->middlewares;

	}
}



?>