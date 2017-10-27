<?php

namespace SwooleFlierMouseFramework;

class App
{
	static protected $di = [];

	public function run ()
	{
		if (isset(self::$di['loader'])) {
			self::$di['loader']->register();
		}

		if (!isset(self::$di['router'])) {
			//ex
		}
		else {
			$route = self::$di['router']->dispatcher();
			var_dump($route);
		}
	}

	public function setDi ($name, $function)
	{
		self::$di[ $name ] = $function;
	}
}