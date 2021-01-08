<?php
namespace app\core;

class Session {

	const FLASH_KEY='flash_messages';

	public function __construct(){
		session_start();
		$flashMsgs=$_SESSION[self::FLASH_KEY] ?? [];
		foreach ($flashMsgs as $key=>&$fMsg) {
				$fMsg['remove']=true;
				
			}
			$_SESSION[self::FLASH_KEY]=$flashMsgs;
			

	}

	public function setFlashMsg($key,$msg){

		
		$_SESSION[self::FLASH_KEY][$key]=[

					'remove'=>false,
				'value'=>$msg,
			];

	}
	public function getFlashMsg($key){

		return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
	}
	public function __destruct(){
		$flashMsgs=$_SESSION[self::FLASH_KEY] ?? [];
		foreach ($flashMsgs as $key=>&$fMsg) {
				if($fMsg['remove']){
					unset($flashMsgs[$key]);
				}
				
			}
			$_SESSION[self::FLASH_KEY]=$flashMsgs;
			

	}
}



?>