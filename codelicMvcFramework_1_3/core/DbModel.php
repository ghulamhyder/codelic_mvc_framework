<?php
namespace app\core;
//use app\core\Model;
//use app\core\Application;

Abstract class DbModel extends Model{

	

	Abstract  static function tableName():string;
	Abstract public function attributes():array;
	Abstract static function primaryKey():string;
	Abstract static function prepare(string $sql);

	

		public function save():bool{

			$tableName=static::tableName();
		 	$attributes=$this->attributes();

		$myattri=implode(',', $attributes);

		

		$bindAttri=array_map(function($attri){

			return ":{$attri}";

		}, $attributes);

		$binding=implode(',',$bindAttri);

		
		$SQL="INSERT INTO {$tableName} ({$myattri})values({$binding});";
		//echo "<pre>";
		//var_dump($SQL);
		//echo "</pre>";exit;

		$stm=Application::$app->db->pdo->prepare($SQL);
		foreach ($attributes as  $attribute) {

			$stm->bindValue(":{$attribute}",$this->{$attribute});
			
		}

		$stm->execute();

		return true;
		

		}//end


		public static function findOne(array $where=[]){

			$class=static::class;
			$tableName=$class::tableName();
			
			$arrKeys=array_keys($where);


			$myAtrri=array_map(function($attri){

				return "$attri=:$attri";

			}, $arrKeys);

			$values=implode(" AND ", $myAtrri);
			

			$SQL="SELECT * FROM {$tableName} WHERE {$values};";
			$stm=static::prepare($SQL);
			foreach ($where as $key => $value) {
				$stm->bindValue(":{$key}",$value);
			}
			$stm->execute();
			return $stm->fetchObject(static::class);

			//echo "<pre>";
			//var_dump($SQL);
			//echo "</pre>";exit;

			

		}
		

}


?>