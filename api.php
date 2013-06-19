<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$db = new \Fxrm\Store\SQLiteBackend('sqlite:test.db');

$hasSession = isset($_GET['session']);

$sm = \Fxrm\Store\Storable::implement('\\Fxrm\\Authentication\\SessionManager', $db);

$app = $hasSession ?
        \Fxrm\Store\Storable::implement('\\TodoApp\\LoggedInService', $db, $sm, $_GET['session']) :
        \Fxrm\Store\Storable::implement('\\TodoApp\\UserLoginService', $db, $sm);

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
