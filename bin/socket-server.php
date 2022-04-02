<?php

//server.php
require __DIR__ . '/../vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Session\SessionProvider;
use Symfony\Component\HttpFoundation\Session\Storage\Handler;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Helper\NiSocket as NiSocketController;

// setup laravel
$capsule = new Capsule;
$capsule->addConnection([
'driver' => 'mysql',
'host' => '127.0.0.1',
'database' => 'hmvc',
'username' => 'root',
'password' => "",
]);
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();


$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new NiSocketController()
        )
    ),
    9788
);
$server->run();
/*
$ip = 'ni-hmvc.test';
$port = "9748";

$memcache = new Memcache;
$memcache->connect($ip, 11211);

$session = new SessionProvider(
    new NiSocket,
    new Handler\MemcacheSessionHandler($memcache)
);

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            $session
        )
    ),
    $port,
    $ip
);
$server->run(); */
