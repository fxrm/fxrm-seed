<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$ctx = new \TodoApp\ActionContext();
$app = $ctx->getStore()->implement('\\TodoApp\\LoggedInApplication', $_GET['session']);

$setEmailForm = new \Fxrm\Action\Form($ctx, 'api.php/setEmail?session=' . rawurlencode($_GET['session']), 'TodoApp\\LoggedInApplication', 'setEmail');

var_dump($app->findAllUsers());

$mustache = new Mustache_Engine(array(
    'strict_callables' => true,
    'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/views')
));

echo $mustache->render('index', array(
    'setEmailForm' => new \Fxrm\Mustache\FormHelper($setEmailForm, array('email' => $app->getEmail()))
));

?>
