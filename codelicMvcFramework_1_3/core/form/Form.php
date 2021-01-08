<?php
namespace app\core\form;

class Form {


	public static function begin($action, $method):object{

		echo sprintf("<form name='form1' action='%s' method='%s'>",$action,$method);
		return new Form;

	}

	public static function end(){

		return "</form>";
	}

	public function field(object $model,string $attribute):object{

		return new Field($model,$attribute);
	}
}



?>