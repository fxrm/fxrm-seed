<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$storable = new \Fxrm\Store\Environment('store.json');
$ctxInit = include(__DIR__ . '/context.php');
$ctx = $ctxInit($storable);

$handler = $ctx->createHandler('\\TodoApp\\LoggedInApplication');

var_dump($handler->getInstance()->findAllUsers());

$form = $handler->createForm('api.php/setEmail', 'setEmail');

if ($form->hasReturnValue()) {
    echo '<p>User information updated!</p>';
}

$form->start();

echo '<p>' . htmlspecialchars($form->getActionError()) . '</p>';

$form->field('email', 'text');
echo '<b>' . htmlspecialchars($form->getFieldError('email')) . '</b>';

echo '<button type="submit">Set Email</button>';

$form->end();

?>
