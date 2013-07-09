<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$storable = new \Fxrm\Store\Environment('store.json');
$ctxInit = include(__DIR__ . '/context.php');
$ctx = $ctxInit($storable);

$service = $ctx->createService('\\TodoApp\\Application');

$form = new \Fxrm\Action\Form($service, 'api.php/login', array(), 'login');

if ($form->hasReturnValue()) {
    header('Location: ' . 'index.php?session=' . urlencode($form->getReturnValue()));
    return;
}

$form->start();

echo '<p>';
echo $form->getActionError();
echo '</p>';

$form->field('email', 'text');
$form->field('password', 'password');

echo '<button type="submit">Submit</button>';

$form->end();

?>
