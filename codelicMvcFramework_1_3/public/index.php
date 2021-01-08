<?php 

	use app\core\Application;
	use \app\controllers\AuthController;
	use \app\controllers\SiteController;
	use \app\models\UserRegisterModel;

	require_once __DIR__.'./../config/config.php';
	require_once __DIR__.'./../vendor/autoload.php';

	$envdot=Dotenv\Dotenv::createImmutable(dirname(__DIR__));
	$envdot->load();
	
	$config=[

			'userClass'=>UserRegisterModel::class,

			'db'=>[

				'dsn'=>$_ENV['DB_DSN'],
				'user'=>$_ENV['DB_USER'],
				'pass'=>$_ENV['DB_PASSWORD'],


			]



	];
	

	$app=new Application(dirname(__DIR__),$config);

	$app->router->get('/',function(){
			return "hello world";
	});

	$app->router->get('/',[SiteController::class,'home']);
	$app->router->get('register',[AuthController::class,'register']);
	$app->router->post('register',[AuthController::class,'register']);

	$app->router->get('login',[AuthController::class,'login']);
	$app->router->post('login',[AuthController::class,'login']);

	$app->router->get('logout',[AuthController::class,'logout']);
	$app->router->get('profile',[AuthController::class,'profile']);
	//$app->router->get('contact','contact');

	$app->run();



 ?>