<?php

return function(\Fxrm\Store\Environment $storable) {
    return new \Fxrm\Action\Context(function ($className, $argList) use($storable) {
        return $storable->implementArgs($className, $argList);
    }, array(
        'TodoApp\\Email' => new \Fxrm\Action\ValueSerializer(),
        'TodoApp\\UserId' => new \Fxrm\Action\StoreIdSerializer($storable)
    ), array(
        'TodoApp\\ApplicationException' => function ($e) {
            // return local class name of the exception
            return substr(get_class($e), strlen('TodoApp\\'));
        }
    ));
};

?>
