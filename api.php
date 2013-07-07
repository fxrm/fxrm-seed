<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$storable = new \Fxrm\Store\Environment('store.json');
$ctxInit = include(__DIR__ . '/context.php');
$ctx = $ctxInit($storable);

$hasSession = isset($_GET['session']);

$handler = $hasSession ?
        $ctx->createHandler('\\TodoApp\\LoggedInApplication') :
        $ctx->createHandler('\\TodoApp\\Application');

// get the method corresponding to current route
$methodName = isset($_SERVER['PATH_INFO']) ? substr($_SERVER['PATH_INFO'], 1) : '';

$handler->invoke($methodName);

?>
