<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$ctx = include(__DIR__ . '/context.php');

$hasSession = isset($_GET['session']);

$service = $hasSession ?
        $ctx->createService('\\TodoApp\\LoggedInApplication') :
        $ctx->createService('\\TodoApp\\Application');

// get the method corresponding to current route
$methodName = isset($_SERVER['PATH_INFO']) ? substr($_SERVER['PATH_INFO'], 1) : '';

\Fxrm\Action\Form::invoke($service, $methodName);

?>
