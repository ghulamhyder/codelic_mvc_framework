<?php 

	use app\core\Application;
	require_once __DIR__.'./vendor/autoload.php';

	$envdot=Dotenv\Dotenv::createImmutable(__DIR__);
	$envdot->load();
	
	$config=[

			'db'=>[

				'dsn'=>$_ENV['DB_DSN'],
				'user'=>$_ENV['DB_USER'],
				'pass'=>$_ENV['DB_PASSWORD'],


			]



	];

	$app=new Application(__DIR__,$config);

	



	$app->db->ApplyMigrations();



 ?>