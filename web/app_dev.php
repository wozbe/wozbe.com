<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
$allowedIP = array('10.1.1.1', '127.0.0.1', '82.231.125.242', 'fe80::1', '::1');
if (!in_array(@$_SERVER['HTTP_CLIENT_IP'], $allowedIP) && !in_array(@$_SERVER['HTTP_X_FORWARDED_FOR'], $allowedIP) && !in_array(@$_SERVER['REMOTE_ADDR'], $allowedIP)) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/../app/AppKernel.php';

$kernelOptions = array();

// Uncomment the following to use the shared memory and speed vms
$kernelOptions = array(
    'cache_dir' => sprintf('/dev/shm/%s/cache/', $_SERVER['SERVER_NAME']),
    'log_dir'   => sprintf('/dev/shm/%s/logs/', $_SERVER['SERVER_NAME']),
);

$kernel = new AppKernel('dev', true, $kernelOptions);
$kernel->loadClassCache();
Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
