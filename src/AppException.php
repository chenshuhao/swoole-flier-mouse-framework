<?php

namespace SwooleFlierMouseFramework;

use SwooleFlierMouseBase\Command\Command;
use SwooleFlierMouseBase\http\Response;

class AppException extends \Exception
{
	public function response(Response $_response){
		$this->getMessage();
		$this->getCode();

		if($this->getCode()){
			$_response
				->setStatusCode($this->getCode())
				->setBody($this->getMessage());
		}else{
			Command::line($this->getMessage());
		}
	}
}