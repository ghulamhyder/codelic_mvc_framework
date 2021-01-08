<?php


class m0001_initial{
	
		public \PDO $pdo;
	public function __construct(\PDO $pdo){
			$this->pdo=$pdo;
	}
	
	public function up($migration){

		$SQL="CREATE TABLE IF NOT EXISTS users(
			
			id int not null auto_increment primary key,
			fname varchar(255) not null,
			lname varchar(255) not null,
			email varchar(255) not null,
			status tinyint not null,
			create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
			)ENGINE=INNODB;";
		$this->pdo->exec($SQL);
	}

	public function down(){
		$SQL="DROP TABLE users";
		$this->pdo->exec($SQL);
		
	}
}


?>

