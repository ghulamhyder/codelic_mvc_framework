<?php


class m0002_something{
	
	public \PDO $pdo;
	public function __construct(\PDO $pdo){
			$this->pdo=$pdo;
	}
	
	public function up(){

		$sql="ALTER TABLE users 
				ADD COLUMN password varchar(255) not null;";
			$this->pdo->exec($sql);
	}

	public function down(){

				$sql="ALTER TABLE users 
				DROP COLUMN password;";
			$this->pdo->exec($sql);
	}
}


?>

