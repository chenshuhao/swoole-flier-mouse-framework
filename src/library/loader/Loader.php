<?php

namespace SwooleFlierMouseFramework\library\loader;

use Nette\Loaders\RobotLoader;
use SwooleFlierMouseFramework\App;

class Loader
{
	static public $dirs = [];

	public function addDir ($path)
	{
		self::$dirs[] = $path;

		return $this;
	}

	public function register ($temp_dir = NULL)
	{
		$robot_loader = new RobotLoader();
		foreach (self::$dirs as $dir) {
			$robot_loader->addDirectory($dir);
		}

		if (NULL !== $temp_dir) {
			$robot_loader->setTempDirectory($temp_dir);
		}
		else {
			$robot_loader->setTempDirectory(App::$temp_dir);
		}

		$robot_loader->register();
	}
}