<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$storable = new \Fxrm\Store\Environment('store.json');
$ctxInit = include(__DIR__ . '/context.php');
$ctx = $ctxInit($storable);

$hasSession = isset($_GET['session']);

$app = $hasSession ?
        $storable->implement('\\TodoApp\\LoggedInApplication', $_GET['session']) :
        $storable->implement('\\TodoApp\\Application');

// get the method corresponding to current route
$methodName = isset($_SERVER['PATH_INFO']) ? substr($_SERVER['PATH_INFO'], 1) : '';

$handler = $ctx->createHandler(array('TodoApp\\ApplicationException' => function ($e) {
    // return local class name of the exception
    return substr(get_class($e), strlen('TodoApp\\'));
}));

$handler->invoke($app, $methodName);

?>
