<?php

namespace SwooleFlierMouseBase\library\loader;

use Nette\Loaders\RobotLoader;

class Loader
{
	static public $dirs = [];

	static public function addDir ($path)
	{
		self::$dirs[] = $path;
	}

	static public function register(){
		$robot_loader = new RobotLoader();
		foreach (self::$dirs as $dir){
			$robot_loader->addDirectory($dir);
		}

		$robot_loader->register();
	}
}