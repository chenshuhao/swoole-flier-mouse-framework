<?php

namespace SwooleFlierMouseFramework;

use SwooleFlierMouseBase\Command\Command;

class App
{
	static protected $di       = [];
	static public    $root_dir = NULL;
	static public    $temp_dir = NULL;

	public function LoadComponents ()
	{
		if (!self::$root_dir) {
			self::$root_dir = realpath(__DIR__ . '/../');
		}

		if (!self::$temp_dir) {
			self::$temp_dir = self::$root_dir . DIRECTORY_SEPARATOR . 'temp';
			if (!is_dir(self::$temp_dir)) {
				mkdir(self::$temp_dir);
			}
		}

		if (isset(self::$di['loader'])) {
			self::$di['loader']->register();
		}
		if (isset(self::$di['router'])) {
			self::$di['router']->register();
		}

		if (isset(self::$di['db'])) {
			self::$di['db']->register();
		}

		else {
			Command::line('There is no registered route, and the default page will be accessed!');
		}

		return $this;
	}

	public function setRootDir ($dir)
	{
		self::$root_dir = $dir;

		return $this;
	}

	public function setTempDir ($dir)
	{
		self::$temp_dir = $dir;

		return $this;
	}

	public function dispatcher ($request, $response)
	{
		if (isset(self::$di['router'])) {
			$route = self::$di['router']->dispatcher();

			return $this->handle($route, $request, $response);

		}
		else {
			return $this->defaultPage();
		}
	}

	public function handle ($route, $request, $response)
	{
		if (is_array($route[1])) {
			if (!class_exists($route[1][0]) || !method_exists($route[1][0], $route[1][1])) {
				throw new AppException("class {$route[1][0]} {$route[1][1]} does not have a method", 500);
			}
			else {
				$route[1][0]           = new $route[1][0];
				$route[1][0]->request  = $request;
				$route[1][0]->response = $response;
				$params                = $route[2];
			}

			return call_user_func_array($route[1], [$params]);
		}
	}

	public function setDi ($name, $function)
	{
		self::$di[ $name ] = $function;

		return $this;
	}

	private function defaultPage ()
	{
		return "<div style='font-size:40px;display: flex;flex-direction:column;justify-content: center;align-items: center'><div>Thank you!</div><div>Welcome to use SwooleFlierMouseFramework!</div><div>enjoy it slowly! </div></div>";
	}
}