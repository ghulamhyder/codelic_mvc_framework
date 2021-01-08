<?php
namespace app\core;
use app\core\Model;

Abstract class DbModel extends Model{



	Abstract public static function tableName():string;
	Abstract public function attributes():array;

	public function save(){

		$tableName=$this->tableName();
		$attributes=$this->attributes();

		$params=array_map(function($attri){
			return ":$attri";
		},$attributes);
		$strAttri=implode(',', $attributes);
		$strParams=implode(',', $params);

		$SQL="INSERT INTO {$tableName}({$strAttri})values({$strParams});";
		$stm=$this->prepare($SQL);
		foreach ($attributes as $attri) {
			$value=$this->{$attri};
			$stm->bindValue(":$attri",$value);
		}

		$record=$stm->execute();
		return true;
		

	}//end

	
	public function prepare($sql){
		return Application::$app->db->pdo->prepare($sql);
	}

	

}


?>