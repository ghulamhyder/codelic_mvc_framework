<?php
 
 class _0001_initial{

 	public \PDO $db;
 	public function __construct($pdo){

 		$this->db=$pdo;

 	}

 	public function up(){

 		$SQL="CREATE TABLE IF NOT EXISTS users(
			
		id int not null auto_increment primary key,
		fname varchar(255) not null,
		lname varchar(255) not null,
		email varchar(255) not null,
		status tinyint not null,
		createAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP


	
 	)ENGINE=INNODB;";

 	$this->db->exec($SQL);

 	}
 	public function down(){

 		$this->db->exec("DROP TABLE users");

 		
 	}
 }


?>