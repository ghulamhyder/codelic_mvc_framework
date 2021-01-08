<?php
namespace app\core;

class Router{

	public Request $request;
	public Response $response;
	protected array $myarr=[];
	public function __construct(Request $request,Response $response){
		$this->request=$request;
		$this->response=$response;
	}

	public function get($path,$callback){
		$this->myarr['get'][$path]=$callback;
	}
	public function post($path,$callback){
		$this->myarr['post'][$path]=$callback;		
	}

	public function resolve(){

		$path=$this->request->getPath();
		$method=$this->request->getMethod();
		$callback=$this->myarr[$method][$path] ?? false;

		if($callback != true){
			//$this->response->setStatusCode(404);
			Application::$app->response->setStatusCode(404);
			return $this->renderView('_404');
			//return $this->notFoundMsg('Not Found');
			
		}
		if(is_string($callback)){
			return $this->renderView($callback);
		}
		if(is_array($callback)){
			Application::$app->controller=new $callback[0]();
			$callback[0]=Application::$app->controller;
		}

		return  call_user_func($callback,$this->request);
	}//end

	public function renderView($viewName,$udata=[]){

		$layoutContent=$this->layoutContent();
		$renderOnlyView=$this->renderOnlyView($viewName,$udata);
		return str_replace('{{content}}', $renderOnlyView, $layoutContent);
	
	}
	public function notFoundMsg($viewName){

		$layoutContent=$this->layoutContent();
		//$renderOnlyView=$this->renderOnlyView($viewName,$udata);
		return str_replace('{{content}}', $viewName, $layoutContent);
	
	}
	protected function layoutContent(){
		$layout=Application::$app->controller->layout ?? 'main';
		ob_start();
		include_once Application::$ROOT_DIR.'./Views/layouts/'.$layout.'.php';
		return ob_get_clean();
	}
	protected function renderOnlyView($viewName,$udata){
		foreach ($udata as $key => $value) {
			${$key}=$value;
		}
		ob_start();
		include_once Application::$ROOT_DIR.'./Views/'.$viewName.'.php';
		return ob_get_clean();
	}

}

?>