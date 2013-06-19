<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$db = new \Fxrm\Store\SQLiteBackend('sqlite:test.db');
$storable = new \Fxrm\Store\Storable($db);

$hasSession = isset($_GET['session']);

$app = $hasSession ?
        $storable->implement('\\TodoApp\\LoggedInApplication', $_GET['session']) :
        $storable->implement('\\TodoApp\\Application');

\Fxrm\Action\Handler::invoke($app, function ($className, $v) use($app) {
    if ($className === 'TodoApp\\Email') {
        return new \TodoApp\Email($v);
    }

    return \Fxrm\Store\Storable::intern($app, $className, $v);
}, function ($v) use($app) {
    // serialize app exceptions as their class names
    if ($v instanceof \Exception) {
        $exceptionClass = get_class($v);

        // re-throw unrecognized exceptions
        if (substr($exceptionClass, 0, 8) !== 'TodoApp\\') {
            throw $v;
        }

        return substr(get_class($v), 8);
    }

    return \Fxrm\Store\Storable::extern($app, $v);
});

?>
