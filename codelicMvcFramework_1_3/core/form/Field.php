<?php
namespace app\core\form;


class Field {

	public const TYPE_TEXT='text';
	public const TYPE_EMAIL='email';
	public const TYPE_PASSWORD='password';

	public $model;
	public string $attribute;
	protected static string $type;
	public function __construct(object $model,string $attribute){

		$this->model=$model;
		$this->attribute=$attribute;
		self::$type=self::TYPE_TEXT;


	}

	public function __toString(){


		return sprintf("

		<div class='form-group'>
			<label>%s</label>
			<input type='%s' class='form-control%s' name='%s' value='%s' placeholder='%s...'>
			<span class ='invalid-feedback'>
				%s
			</span>
		</div>",


				$this->model->labels()[$this->attribute],
				self::$type,
				$this->model->hasError($this->attribute) ? ' is-invalid' :'',
				$this->attribute,
				$this->model->{$this->attribute},
				$this->model->labels()[$this->attribute],
				$this->model->getErrorMsg($this->attribute)


				);
	}//end


	public function setType(){

		self::$type=self::TYPE_PASSWORD;
		return $this;
	}
}



?>
