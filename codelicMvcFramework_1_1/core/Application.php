<?php
namespace app\core;
use app\core\Router;
use app\core\Request;
use app\core\Response;
use app\core\Database;
use app\core\Session;


class Application {

	public Router $router;
	public Request $request;
	public Response $response;
	public Controller $controller;
	public Database $db;
	public Session $session;
	public static Application $app;
	public static string $ROOT_DIR;

	public function __construct(string $rootPath,array $config){

		self::$ROOT_DIR=$rootPath;
		self::$app=$this;
		$this->response=new Response();
		$this->session=new Session();
		$this->request=new Request();
		$this->router=new Router($this->request,$this->response);
		$this->db=new Database($config);

	}


	public function run(){
		echo $this->router->resolve();
	}
}


?>