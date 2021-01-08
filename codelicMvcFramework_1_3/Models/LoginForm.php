<?php
namespace app\models;
use app\core\Model;
use app\core\Application;
class LoginForm  extends Model{

		public string $email='';
		public string $password='';

	public function labels():array{


			return [

				"email"=>"Email Address",
				"password"=>"Password",


			];
		}




	public function rules():array{

		return [

			"email"=>[self::RULE_REQUIRED,self::RULE_EMAIL],
			"password"=>[self::RULE_REQUIRED,[self::RULE_MIN,'min'=>8,'max'=>24 ] ],


		];
	}

	public function login(){

		$user=UserRegisterModel::findOne(['email'=>$this->email]);///ku ke ye ek hi folder ma ha us liye is k namespce ko call nhi kery gay exp=> use app\model\userRegisterModel

		if(!$user){

			$this->addErrorMsg('email','this email is not exists in database');
			return false;

		}
		if(!password_verify($this->password, $user->password)){

			$this->addErrorMsg('password','in-valid password');
			return false;

		}
		else{

			return Application::$app->login($user);

		}
		

	}

}


?>