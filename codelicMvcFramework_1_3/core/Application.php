<?php
namespace app\core;
use app\models\UserRegisterModel;


class Application {

	public Router $router;
	public Request $request;
	public Response $response;
	//public UserRegisterModel $myModel;
	public static string $ROOT_DIR;
	public Controller $controller;
	public ?DbModel $user;
	public static Application $app;
	public string $userClass;
	public Session $session;
	public Database $db;


	public function __construct($rootPath,$config){
		self::$app=$this;
		self::$ROOT_DIR=$rootPath;
		$this->userClass=$config['userClass'];
		$this->response=new Response();
		$this->session=new Session();
		$this->request=new Request();
		$this->router=new Router($this->request,$this->response);

		$this->db=new Database($config['db']);

		$getUserPrimaryValue=$this->session->get('user');
		if($getUserPrimaryValue){


			$primaryKey=$this->userClass::primaryKey();
			//echo "<pre>";
			//var_dump($primaryKey);
			//echo "</pre>";exit;
			$this->user=$this->userClass::findOne([$primaryKey=>$getUserPrimaryValue]);

			

		} else {
			$this->user=null;
		}


	}


	public function login(DbModel $user){

		$this->user=$user;
		$primaryKey=$user->primaryKey();
		$primaryValue=$user->{$primaryKey};
		$this->session->set("user",$primaryValue);
		return true;
}

	public static function isGuest(){
		
	return !self::$app->user;

}

 public function logout(){

 	$this->user=null;
 	self::$app->session->remove('user');
 }


	public function run(){

		try{
		echo $this->router->resolve();
	}catch(\Exception $e){
			$this->response->setStatusCode(404);
		echo $this->router->renderView('_error',['exception'=>$e]);
		
	}
		
	}
}




?>


