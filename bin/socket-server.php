<?php

//server.php
require __DIR__ . '/../vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Session\SessionProvider;
use Symfony\Component\HttpFoundation\Session\Storage\Handler;
use Helper\NiSocket as NiSocketController;

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
