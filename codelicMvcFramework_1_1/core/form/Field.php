<?php
namespace app\core\form;

class Field {

	
	const TYPE_TEXT='text';
	const TYPE_EMAIL='email';
	const TYPE_PASSWORD='password';
	const TYPE_NUM='number';
	public $model;
	public string $attribute;
	public string $type;

	public function __construct($model,$attribute){
		$this->model=$model;
		$this->attribute=$attribute;
		$this->type=self::TYPE_TEXT;
	}

	public function __toString(){

		return sprintf("<div class='form-group'>
		<label>%s</label>
		<input type='%s' class='form-control%s' name='%s' value='%s' placeholder='%s..''>
		<span class='invalid-feedback'>
		 	%s
		</span> 
	</div>",
				$this->model->labels()[$this->attribute],
			  	$this->type,
			  	$this->model->hasError($this->attribute) ? ' is-invalid':'',	
			  	$this->attribute,
			  	$this->model->{$this->attribute},
			  	ucfirst($this->attribute),
			  	$this->model->getFirstErrorMsg($this->attribute) ?? '');
	}

	public function setType(){
		$this->type=self::TYPE_PASSWORD;
		return $this;
	}
}


?>