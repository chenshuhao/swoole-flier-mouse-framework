<?php

namespace SwooleFlierMouseFramework\library\router;

use FastRoute;
use FastRoute\RouteCollector;
use SwooleFlierMouseFramework\AppException;

class Router extends RouterAbstract
{
	static public $routes    = [];
	static public $namespace = [];

	/* 添加路由*/
	public function addRoute ($method, $route, $handler)
	{
		self::$routes[] = [
			'method'  => $method,
			'route'   => $route,
			'handler' => $handler
		];

		return $this;
	}

	static public function dispatcher ()
	{
		$http_method = $_SERVER['REQUEST_METHOD'];
		$uri         = $_SERVER['REQUEST_URI'];

		$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
			foreach (self::$routes as $route) {
				$r->addRoute($route['method'], $route['route'], $route['handler']);
			}
		});

		$route_info = $dispatcher->dispatch($http_method, rawurldecode($uri));
		switch ($route_info[0]) {
			case FastRoute\Dispatcher::NOT_FOUND:
				throw new AppException('404 Not Found',404);
				break;
			case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
				$allowedMethods = $route_info[1];
				throw new AppException('405 Method Not Allowed',405);
				break;
			case FastRoute\Dispatcher::FOUND:
				$handler = $route_info[1];
				$vars    = $route_info[2];

				return $route_info;
				// ... call $handler with $vars
				break;
		}
	}

}