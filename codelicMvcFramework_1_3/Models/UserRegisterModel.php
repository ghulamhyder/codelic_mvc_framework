<?php
namespace app\models;
//use app\core\Model;
use app\core\DbModel;
use app\core\Application;

class UserRegisterModel extends DbModel{

		public string $fname='';
		public string $lname='';
		public string $email='';
		public int $status=0;
		public string $password='';
		public string $pass2='';

		public function register(){

			$this->password=password_hash($this->password, PASSWORD_BCRYPT,['cost'=>8]);
			return $this->save();
		}

		public static function tableName():string{

			return "users";
		}
		public static function primaryKey():string{

			return "id";
		}
		public function userDisplayName():string{

			return $this->fname.' '.$this->lname;
		}

		public function attributes():array{

			return [

				"fname",
				"lname",
				"email",
				"status",
				"password",

			];
		}
		public static function prepare(string $sql){
			return Application::$app->db->pdo->prepare($sql);
		}
		public function labels():array{
			
			return [
				"fname"=>'First Name',
				"lname"=>'Last Name',
				"email"=>'Email',
				"password"=>'Password',
				"pass2"=>'Confirm-Password',

			];

		}

		public function rules():array{

		return [

	'fname'=>[self::RULE_REQUIRED],
	'lname'=>[self::RULE_REQUIRED],
	'email'=>[self::RULE_REQUIRED,self::RULE_EMAIL,[self::RULE_UNIQUE,'class'=>static::class] ],
				'password'=>[self::RULE_REQUIRED,[self::RULE_MIN,'min'=>8],[self::RULE_MAX,'max'=>24] ],
				'pass2'=>[self::RULE_REQUIRED,[self::RULE_MATCH,'match'=>'password'] ],


			];
		}
}


?>