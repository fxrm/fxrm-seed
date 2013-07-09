<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$ctx = include(__DIR__ . '/context.php');

$service = $ctx->createService('\\TodoApp\\Application');

$mustache = new Mustache_Engine(array(
    'strict_callables' => true,
    'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/views'),
    'helpers' => array(
        'loginForm' => new \Fxrm\Action\Form($service, 'api.php/login', array(), 'login', array())
    )
));

echo $mustache->render('login');

?>
