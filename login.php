<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$ctx = new TodoApp\ActionContext();

$loginForm = new \Fxrm\Action\Form($ctx, 'api.php/login', 'TodoApp\\Application', 'login');

if ($loginForm->getSuccessStatus()) {
    header('Location: ' . 'index.php?session=' . urlencode($loginForm->getSuccessValue()));
    return;
}

$mustache = new Mustache_Engine(array(
    'strict_callables' => true,
    'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/views')
));

echo $mustache->render('login', array(
    'loginForm' => new \Fxrm\Mustache\FormHelper($loginForm)
));

?>
