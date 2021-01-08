<?php
 
  use app\core\Application;
  use app\controllers\SiteController;
   use app\controllers\AuthController;
 include_once __DIR__.'./../config/config.php';
  include_once __DIR__.'/../vendor/autoload.php';

$dotenv=Dotenv\Dotenv::createImmutable(dirname(__DIR__));
 $dotenv->load();

 $config=[

      'db'=>[

          'dsn'=>$_ENV['DB_DSN'],
          'user'=>$_ENV['DB_USER'],
          'pass'=>$_ENV['DB_PASSWORD'],

      ]


 ];
 

  $app=new Application(dirname(__DIR__),$config['db']);
  
  
  //$app->router->get('contact','contact');
  $app->router->get('/',[SiteController::class,'home']);
  $app->router->post('handleContact',[SiteController::class,'handleContact']);
  
  $app->router->get('login',[AuthController::class,'login']);
  $app->router->post('login',[AuthController::class,'login']);
  $app->router->get('register',[AuthController::class,'register']);
  $app->router->post('register',[AuthController::class,'register']);

  $app->run();


?>