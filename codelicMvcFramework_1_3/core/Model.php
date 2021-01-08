<?php
namespace app\core;
//use app\core\Application;


Abstract class Model{

	public const RULE_REQUIRED='required';
	public const RULE_EMAIL='email';
	public const RULE_MIN='min';
	public const RULE_MAX='max';
	public const RULE_MATCH='match';
	public const RULE_UNIQUE='unique';
	public array $error=[];

	Abstract public function rules():array;
	Abstract public function labels():array;


	public function loadData(array $data){

			foreach ($data as $attribute => $value) {
				
				$this->{$attribute}=$value;
			}
	}


	public function validate(){

		foreach ($this->rules() as $attributes => $rules) {
			$value=$this->{$attributes};
			foreach ($rules as $rule) {
				
				$ruleName=$rule;
				if(is_array($ruleName)){
					$ruleName=$rule[0];
				}

				if($ruleName===self::RULE_REQUIRED && !$value){

					$this->addError($attributes,self::RULE_REQUIRED);
				}
				if($ruleName===self::RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL)){

					$this->addError($attributes,self::RULE_EMAIL);
				}
				if($ruleName===self::RULE_MIN && strlen($value) < $rule['min']){

					$this->addError($attributes,self::RULE_MIN,$rule);
				}
				if($ruleName===self::RULE_MAX && strlen($value) > $rule['max']){

					$this->addError($attributes,self::RULE_MAX,$rule);
				}
				if($ruleName===self::RULE_MATCH && $value != $this->{$rule['match']}){
					$rule['match']=ucfirst($rule['match']);
					$this->addError($attributes,self::RULE_MATCH,['field1'=>$rule['match'] ]);
				}

				if($ruleName===self::RULE_UNIQUE){
					$class=$rule['class'];
					$myattri=$class::tableName();
					$uniqueAttri=$rule['attribute'] ?? $attributes;
					$SQL="SELECT * FROM users WHERE {$uniqueAttri}=:attri;";
					$stm=Application::$app->db->pdo->prepare($SQL);
					$stm->bindValue(":attri",$this->{$uniqueAttri});
					$stm->execute();
					$record=$stm->fetchAll();
					if($record){
				$this->addError($attributes,self::RULE_UNIQUE,['field1'=>ucfirst($attributes)]);

					}
					else{
						return true;
					}

				}
			}//innerlooop
		}//outerloop
		return empty($this->error);
	}//endfunc

	public function addError(string $attri,string $ruleKey,array $rule=[]){

		$msg=self::errorMessages()[$ruleKey] ?? '';
		foreach ($rule as $key => $value) {
			$msg=str_replace("{{$key}}",$value,$msg);
		}
		$this->error[$attri][]=$msg;
	}

	public function hasError($attribute){

			return $this->error[$attribute] ?? false;
	}
	public function getErrorMsg($attribute){

			return $this->error[$attribute][0] ?? '';
	}

	private static function errorMessages():array{

		return [

			self::RULE_REQUIRED=>'this field is required',
			self::RULE_EMAIL=>'this field of email is invalid',
			self::RULE_MIN=>'this field is minimum {min} chars',
			self::RULE_MAX=>'this field is maximum {max} chars',
			self::RULE_MATCH=>'{field1} did not match',
			self::RULE_UNIQUE=>'{field1}  is already exists',

		];
	}
	public  function addErrorMsg($attri,$msg){

		$this->error[$attri][]=$msg;
	}

}


?>