<?php

ini_set('display_errors', 1);

require(__DIR__ . '/vendor/autoload.php');

$storable = new \Fxrm\Store\Environment('store.json');

$hasSession = isset($_GET['session']);

$app = $hasSession ?
        $storable->implement('\\TodoApp\\LoggedInApplication', $_GET['session']) :
        $storable->implement('\\TodoApp\\Application');

// get the method corresponding to current route
$methodName = isset($_SERVER['PATH_INFO']) ? substr($_SERVER['PATH_INFO'], 1) : '';

\Fxrm\Action\Handler::invoke($app, $methodName, function ($className, $v) use($storable) {
    // @todo check e.g. common superclass or something: this is not always one-to-one with Store value objects
    if ($className === 'TodoApp\\Email') {
        return new \TodoApp\Email($v);
    }

    return $storable->import($className, $v);
}, function ($v) use($storable) {
    // serialize app exceptions as their class names
    if ($v instanceof \Exception) {
        $exceptionClass = get_class($v);

        // re-throw unrecognized exceptions
        if (substr($exceptionClass, 0, 8) !== 'TodoApp\\') {
            throw $v;
        }

        return substr(get_class($v), 8);
    }

    return $storable->export($v);
});

?>
