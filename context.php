<?php

return function(\Fxrm\Store\Environment $storable) {
    return new \Fxrm\Action\Context(array(
        'TodoApp\\Email' => new \Fxrm\Action\ValueSerializer(),
        'TodoApp\\UserId' => new \Fxrm\Action\StoreIdSerializer($storable)
    ));
};

?>
