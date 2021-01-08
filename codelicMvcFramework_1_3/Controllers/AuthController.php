<?php
namespace app\controllers;
use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\UserRegisterModel;
use app\models\LoginForm;
use app\core\middlewares\AuthMiddleware;

class AuthController extends Controller{


		public UserRegisterModel $myModel;
		public LoginForm $loginModel;
		public function __construct(){

			$this->myModel=new UserRegisterModel();
			$this->loginModel=new LoginForm();
			$this->registerMiddleware(new AuthMiddleware(['profile']));

		}

	public function login(Request $request,Response $response){

		$data=[
			'title'=>'Sign up Account',
			'body'=>'this is body',
			'model'=>$this->loginModel,

		];

		if($request->isPost()){

			$this->loginModel->loadData($request->getBody());


			if($this->loginModel->validate() && $this->loginModel->login()){
			Application::$app->session->setMsg('success',"You have been successfully login");
			$response->direct('/');
			}

		
		}

		$this->setLayout('auth');
		return $this->render('login',$data);

	}

	public function register(Request $request,Response $response){

		$data=[
			'title'=>'Register Account',
			'body'=>'this is body',
			'model'=>$this->myModel,

		];

		

		if($request->isPost()){

			$this->myModel->loadData($request->getBody());

			if($this->myModel->validate() && $this->myModel->register()){
			Application::$app->session->setMsg('success',"You have been successfully register");
			$response->direct('/');

			}

			$this->setLayout('auth');
			return $this->render('register',$data);
		//echo "<pre>";
		//var_dump($this->myModel);
		//echo "</pre>";exit;
			
		}

		$this->setLayout('auth');
		return $this->render('register',$data);
	}//end func register

	public function logout(Request $request,Response $response){
		Application::$app->logout();
		Application::$app->session->setMsg('success','you have been successfully logout');
		return $response->direct('/');


	}

	public function profile(){

		return $this->render('profile');
	}
}



?>