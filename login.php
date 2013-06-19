<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$db = new \Fxrm\Store\SQLiteBackend('sqlite:test.db');
$storable = new \Fxrm\Store\Storable($db);

$app = $storable->implement('\\TodoApp\\Application');

$form = new \Fxrm\Action\Form($app, 'login');

if ($form->hasReturnValue()) {
    header('Location: ' . 'index.php?session=' . urlencode($form->getReturnValue()));
    return;
}

$form->start('api.php');

echo '<p>';
echo $form->getActionError();
echo '</p>';

$form->field('email', 'text');
$form->field('password', 'password');

echo '<button type="submit">Submit</button>';

$form->end();

?>
