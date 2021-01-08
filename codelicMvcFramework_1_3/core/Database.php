<?php
namespace app\core;

class Database {

	public \PDO $pdo;
	public function __construct($config){

		//echo "<pre>";
		//var_dump($config);
		//echo "</pre>";exit;
		$dsn=$config['dsn'];
		$user=$config['user'];
		$pass=$config['pass'];

		$this->pdo=new \PDO($dsn,$user,$pass);
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);

	}

	public function ApplyMigrations(){

		$newMigrations=[];
		$this->createMigrationsTable();
		$appliedMigrations=$this->appliedMigrations();

		$files=scandir(Application::$ROOT_DIR.'/migrations');
		$applyingForMigrations=array_diff($files,$appliedMigrations);

		foreach ($applyingForMigrations as $migration) {
			
				if($migration=='.' || $migration=='..'){
					continue;
				}
				include_once Application::$ROOT_DIR.'/migrations/'.$migration;
				$className=pathinfo($migration,PATHINFO_FILENAME);
				$instance=new $className($this->pdo);

				$newMigrations[]=$migration;
				$this->setMsg("Applyin for Migration $migration");
				$instance->up();
				$this->setMsg("Applied for Migration $migration");

		}

		if(!empty($newMigrations)){

		foreach ($newMigrations as $migration) {
			
			$this->saveMigrations($migration);

		}
	}else {

		$this->setMsg("all migrations are done");
		
	}


	}


	protected function createMigrationsTable(){

		$this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(

		id int not null auto_increment primary key,

		migration varchar(255) not null, 
		createAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	


	)ENGINE=INNODB;");

	}//end

	protected function appliedMigrations(){

		$SQL="SELECT migration from migrations";

		$stm=$this->pdo->prepare($SQL);
		$stm->execute();
		$record=$stm->fetchAll(\PDO::FETCH_COLUMN);
		
		return $record;

	}//end

	protected function saveMigrations(string $migration):void{

		$SQL="INSERT INTO migrations(migration) values(:mymagi);";
		$stm=$this->pdo->prepare($SQL);

		$stm->bindValue(":mymagi",$migration);
		$stm->execute();

	}

	protected function setMsg(String $msg):void{

			echo $msg.PHP_EOL;
	}
}




?>