<?php

namespace SwooleFlierMouseFramework\controllers;

abstract class Controller
{
	public $request  = NULL;
	public $response = NULL;
	public $route    = NULL;
	public $di       = NULL;

	public function getDi ($key)
	{
		return isset($this->di[ $key ]) ? $this->di[ $key ] : NULL;
	}
}
