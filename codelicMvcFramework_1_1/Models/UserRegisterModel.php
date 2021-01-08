<?php
namespace app\models;
use app\core\DbModel;
use app\core\Application;

class UserRegisterModel extends DbModel{

		public string $fname='';
		public string $lname='';
		public string $email='';
		public string $password='';
		public int $status=0;
		public string $pass2='';
		

	public function save(){
		
		return parent::save();
	}


	public static function tableName():string{
		return "users";
	} 

public function labels():array{
		return [
			'fname'=>'First Name',
			'lname'=>'Last Name',
			'email'=>'Email',
			'password'=>'Password',
			'pass2'=>'Confirm-Password',

		];

	}





	public function hasError($attribute){
		return !empty($this->error[$attribute]) ? true : false;

		
	}
	public function getFirstErrorMsg($attribute){
		//echo $this->error[$attribute];exit;
		return !empty($this->error[$attribute][0]) ? $this->error[$attribute][0] : '';
	}

	public function rules():array{

		return [

				'fname'=>[self::RULE_REQUIRED],
				'lname'=>[self::RULE_REQUIRED],
				'email'=>[self::RULE_REQUIRED,self::RULE_EMAIL,[self::RULE_UNIQUE,'class'=>self::class] ],
				'password'=>[self::RULE_REQUIRED,[self::RULE_MIN,'min'=>8], [self::RULE_MAX,'max'=>24] ],
				'pass2'=>[self::RULE_REQUIRED,[self::RULE_MATCH,'match'=>'password'] ],
				


		];
	}

	public function attributes():array{

		return ['fname','lname','email','password','status'];
	}
}


?>