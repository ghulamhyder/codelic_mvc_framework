<?php
namespace app\core;
use app\core\exception\NotFoundException;

class Router {

	public Request $request;
	public Response $response;
	protected array $myArr=[];
	public function __construct(Request $request,Response $response){
		$this->request=$request;
		$this->response=$response;

	}

	public function get($path,$callback){

		$this->myArr['get'][$path]=$callback;

	}
	public function post($path,$callback){

		$this->myArr['post'][$path]=$callback;

	}

	public function resolve(){

		$path=$this->request->getPath();
		$method=$this->request->getMethod();

		$callback=$this->myArr[$method][$path] ?? false;

		if($callback !=true){
			
			$this->response->setStatusCode(404);
			throw new NotFoundException();
			

			
		}
		if(is_string($callback)){

			return $this->renderView($callback);
		}
		if(is_array($callback)){

			$controller=new $callback[0]();
			Application::$app->controller=$controller;
			$controller->action=$callback[1];
			$callback[0]=$controller;
			foreach ($controller->getMiddlewaresArr() as $myMiddleware) {
					$myMiddleware->execute();

			}
			
		}

		return call_user_func($callback,$this->request,$this->response);
		
	}

	public function renderView($viewName,$data=[]){

		$layoutContent=self::layoutContent();
		$renderOnlyView=self::renderOnlyView($viewName,$data);
		return str_replace('{{content}}', $renderOnlyView, $layoutContent);
		
	}
	public static function notFoundMsg($viewName){

		$layoutContent=self::layoutContent();
		//$renderOnlyView=self::renderOnlyView($viewName,$data);
		return str_replace('{{content}}',$viewName , $layoutContent);
		
	}
	protected static function layoutContent(){
		
		$layout=Application::$app->controller->layout ?? 'main';
		ob_start();
		include_once Application::$ROOT_DIR.'./Views/layouts/'.$layout.'.php';
		return ob_get_clean();
		
	}
	protected static function renderOnlyView($viewName,$data){
		ob_start();
		foreach ($data as $key => $value) {
			${$key}=$value;
		}
		
		include_once Application::$ROOT_DIR.'./Views/'.$viewName.'.php';
		return ob_get_clean();
		
	}
}



?>