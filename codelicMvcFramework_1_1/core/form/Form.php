<?php
namespace app\core\form;
use app\core\form\Field;

class Form {


	public static function begin($action,$method){

		echo sprintf("<form name='form1' action='%s' method='%s'>",$action,$method);
		return self::class;
	}

	public function end(){
	return "</form>";
	}

	public static  function field($model,$attribute){

			return new Field($model,$attribute);
	}
}


?>