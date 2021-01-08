<?php
 namespace app\core;

 class Session{

 	public const FLASH_MSG='flash_messages';

 	public function __construct(){

 			session_start();

 		$flashMsgs=$_SESSION[self::FLASH_MSG] ?? [];

 		foreach ($flashMsgs as $key => &$Msg) {
 			
 				$Msg['status']=true;

 		}
 		$_SESSION[self::FLASH_MSG]=$flashMsgs;

 	}

 	public function setMsg($key,$msg){

 		$_SESSION[self::FLASH_MSG][$key]=[

 						"status"=>false,
 						"value"=>$msg,

 					];
 	}

 	public function getMsg($key){

 		return $_SESSION[self::FLASH_MSG][$key]['value'] ?? false;
 	}

 	public function set($key,$value){
 		$_SESSION[$key]=$value;

 	}
 	public function get($key){

 		return $_SESSION[$key] ?? false;

 	}
 	public function remove($key){

 		unset($_SESSION[$key]);

 	}



 	public function __destruct(){

 		$flashMsgs=$_SESSION[self::FLASH_MSG] ?? [];

 		foreach ($flashMsgs as $key => &$Msg) {
 			
 				if($Msg['status']){

 					unset($flashMsgs[$key]);
 				}

 		}
 		$_SESSION[self::FLASH_MSG]=$flashMsgs;

 	}///func
 }//class




