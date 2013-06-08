<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$db = new \Fxrm\Store\SQLiteBackend('sqlite:test.db');
$app = \Fxrm\Store\Storable::implement('\\TodoApp\\LoggedInApplication', $db, $_GET['session']);

var_dump($app->queryAllUsers());

$form = new \Fxrm\Action\Form($app, 'setEmail');

if ($form->hasReturnValue()) {
    echo '<p>User information updated!</p>';
}

$form->start('api.php?session=' . urlencode($_GET['session']));

echo '<p>' . htmlspecialchars($form->getActionError()) . '</p>';

$form->field('email', 'text');
echo '<b>' . htmlspecialchars($form->getFieldError('email')) . '</b>';

echo '<button type="submit">Set Email</button>';

$form->end();

?>
