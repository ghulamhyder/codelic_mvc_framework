<?php
namespace app\core;
use app\core\Application;

class Database {

	public \PDO $pdo;
	public function __construct(array $config){

		$dsn=$config['dsn'];
		$user=$config['user'];
		$pass=$config['pass'];

		$this->pdo=new \PDO($dsn,$user,$pass);
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);

	}

	public function applyMigrations(){

		$newMigrationsArr=[];
		$this->createMigrationsTable();
		$appliedMigrations=$this->appliedMigrations();

		//$this->saveMigration();
		//echo "pre>";
		//var_dump($appliedMigrations);
		//echo "</pre>";exit;

		$files=scandir(Application::$ROOT_DIR.'/migrations');
		

		$toApplyMigrations=array_diff($files,$appliedMigrations);
		
		foreach ($toApplyMigrations as $migration) {
			if($migration=='.' || $migration=='..'){
				continue;
			}

			include_once Application::$ROOT_DIR.'/migrations/'.$migration;
			$className=pathinfo($migration,PATHINFO_FILENAME);
			echo $migration.PHP_EOL;
			
			$instance=new $className($this->pdo);
			$newMigrationsArr[]=$migration;
			/*if(!empty($newMigrationsArr)){
				$this->saveMigration($newMigrationsArr);
				unset($newMigrationsArr);
			}*/ 

			$this->msg("Appyiyng for Migration $migration");
			$instance->up($migration);
			$this->msg("Appyied  Migration $migration");
		}//endloop
		//echo "<pre>";
		//var_dump($newMigrationsArr);
		//echo "</pre>";exit;
		if(!empty($newMigrationsArr)){
			$this->saveMigration($newMigrationsArr);

		}else {
			$this->msg('All Migrations are Applied');
		}
	 

}//end func

	
	protected function saveMigration(array $migrations){
		$migration=array_map(function($m){
			return "('{$m}')";
				}, $migrations);

			$value=implode(',', $migration);

			$sql="insert into migrations (migration)values{$value};";
			$stm=$this->pdo->prepare($sql);
			$stm->execute();
	}
	

	protected function createMigrationsTable(){

		$this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(
			id int not null auto_increment primary key,
			migration varchar(255) not null,
			create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

	)ENGINE=INNODB;");
	}//end

	protected function appliedMigrations(){

		$sql="SELECT migration FROM migrations;";

		$stm=$this->pdo->prepare($sql);
		$stm->execute();
		return $stm->fetchAll(\PDO::FETCH_COLUMN);


	}//end

	protected function msg($msg){
		echo $msg.PHP_EOL;
	}
}





?>

