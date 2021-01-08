<?php


class _0002_something1{

	public  $db;
	public function __construct($db){
		$this->db=$db;

	}

	public function up(){

		$SQL="ALTER TABLE users 
				ADD COLUMN password VARCHAR(255) NOT NULL;";
		$this->db->exec($SQL);


	}
	public function down(){

		$SQL="ALTER TABLE users 
				DROP COLUMN password;";
		$this->db->exec($SQL);

	}
}

?>