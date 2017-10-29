<?php

namespace SwooleFlierMouseFramework\library\db;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
/*
 * 'mysql' => [
    'read' => [
        'host' => '192.168.1.1',
    ],
    'write' => [
        'host' => '196.168.1.2'
    ],
    'sticky'    => true,
    'driver'    => 'mysql',
    'database'  => 'database',
    'username'  => 'root',
    'password'  => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
],


[
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'scl_ad',
			'username'  => 'root',
			'password'  => '123',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		]
 * */
class Db
{
	public $config;

	public function setConfig (array $config)
	{
		$this->config = $config;
		return $this;
	}

	public function register ()
	{
		$capsule = new Capsule;
		$capsule->addConnection($this->config);
		$capsule->setEventDispatcher(new Dispatcher(new Container));
		$capsule->setAsGlobal();
		$capsule->bootEloquent();
	}
}