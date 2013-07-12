<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$hasSession = isset($_GET['session']);

$ctx = new \TodoApp\ActionContext();
$app = $hasSession ?
        $ctx->getStore()->implement('\\TodoApp\\LoggedInApplication', $_GET['session']) :
        $ctx->getStore()->implement('\\TodoApp\\Application');

// get the method corresponding to current route
$methodName = isset($_SERVER['PATH_INFO']) ? substr($_SERVER['PATH_INFO'], 1) : '';

\Fxrm\Action\Form::invoke($ctx, $app, $methodName);

?>
