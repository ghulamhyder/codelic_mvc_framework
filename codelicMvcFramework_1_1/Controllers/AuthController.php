<?php
namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\UserRegisterModel;
use app\core\Application;



class AuthController extends Controller{

	public UserRegisterModel $uModel;
	public function __construct(){
		$this->uModel=new UserRegisterModel();
	}

	public function login(){
		return $this->render('login');
	}

	public function register(Request $request){
		$data=[
			
			'title'=>'Create An User Account',
			'body'=>'this is body',
			'model'=>$this->uModel,
		];

		if($request->isPost()){
			
			
			$this->uModel->loadData($request->getBody());
			
			if($this->uModel->validate() && $this->uModel->save()){
				Application::$app->session->setFlashMsg('success','Thanks for Registering');

				Application::$app->response->redirect('/');
			}
			//echo "<pre>";
			//var_dump($this->uModel->error);
			//echo "</pre>";exit;

		}

		$this->setLayOut('auth');
		return  $this->render('register',$data);
	}//end


}



?>