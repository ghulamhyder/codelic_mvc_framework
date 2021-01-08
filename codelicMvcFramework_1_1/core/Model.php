<?php
namespace app\core;

Abstract class Model {

		const RULE_REQUIRED='required';
		const RULE_EMAIL='email';
		const RULE_MIN='min';
		const RULE_MAX='max';
		const RULE_MATCH='match';
		const RULE_UNIQUE='unique';
		public array $error=[];
		


	Abstract public function rules():array;
	Abstract public function prepare($sql);
	Abstract public function labels():array;

	public function loadData($udata){
		foreach ($udata as $attribute => $value) {
			$this->{$attribute}=$value;
		}

	}
	public function getLabel(){
		return $this->labels();
	}

	public function validate(){

		foreach ($this->rules() as $attribute => $rules) {
			$value=$this->{$attribute};

			foreach ($rules as $rule) {
				$ruleName=$rule;

				if(is_array($ruleName)){
					$ruleName=$rule[0];
				}
				if($ruleName===self::RULE_REQUIRED && empty($value) ){
					$this->addError($attribute,self::RULE_REQUIRED);
				}
				if($ruleName===self::RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL) ){
					$this->addError($attribute,self::RULE_EMAIL,['field'=>$this->getLabel()[$attribute]]);
				}
				if($ruleName===self::RULE_MIN && strlen($value) < $rule['min'] ){
					$this->addError($attribute,self::RULE_MIN,$rule);
				}
				if($ruleName===self::RULE_MAX && strlen($value) > $rule['max'] ){
					$this->addError($attribute,self::RULE_MAX,$rule);
				}
				if($ruleName===self::RULE_MATCH && $value !== $this->{$rule['match']} ){
					$rule['match']=$this->getLabel()[$rule['match']];
					$this->addError($attribute,self::RULE_MATCH,['field'=>$rule['match']]);
				}

				if($ruleName===self::RULE_UNIQUE){
					$className=$rule['class'];
					$tableName=$className::tableName();
					$uniAttri=$rule['attribute'] ?? $attribute;
					$sql="SELECT * FROM {$tableName} WHERE {$uniAttri}=:attri;";
					$stm=$this->prepare($sql);
					$stm->bindValue(':attri',$value);
					$stm->execute();
					$record=$stm->fetchObject();
					if($record){
						$this->addError($attribute,self::RULE_UNIQUE,
							['field'=>$this->getLabel()[$attribute]]);
					}

				}
			}//innerloop
		}//outerlooop
		if(empty($this->error)){
			return true;
		}
	}//ends

public function addError($attribute,$ruleKey,$rule=[]){


			$messgae=$this->errorMessages()[$ruleKey] ?? '';
			foreach ($rule as $key => $value) {
					$messgae=str_replace("{{$key}}",$value,$messgae);
			}
			$this->error[$attribute][]=$messgae;
}

	private function errorMessages():array{

		return [

			self::RULE_REQUIRED=>'This filed is required',
			self::RULE_EMAIL=>'This {filed} is invalid',
			self::RULE_MIN=>'This filed is required minimum {min} chars',
			self::RULE_MAX=>'This filed is required maximum {max} chars',
			self::RULE_MATCH=>'{field} did not match',
			self::RULE_UNIQUE=>'this {field} is alreday exists',

		];
	}
}


?>