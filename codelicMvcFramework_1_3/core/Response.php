<?php
namespace app\core;

class Response {




	public function direct($url){

		return header("Location: ".baseUrl.$url);

	}

	public function setStatusCode(int $code):void{

			http_response_code($code);
	}
}

?>