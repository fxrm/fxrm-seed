<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$ctx = include(__DIR__ . '/context.php');

$service = $ctx->createService('\\TodoApp\\LoggedInApplication');

$app = $service->createInstance();

var_dump($app->findAllUsers());

$mustache = new Mustache_Engine(array(
    'strict_callables' => true,
    'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/views'),
    'helpers' => array(
        'setEmailForm' => new \Fxrm\Action\Form($service, 'api.php/setEmail', array(
            'session' => $app->getSession()
        ), 'setEmail', array(
            'email' => $app->getEmail()
        ))
    )
));

echo $mustache->render('index');

?>
