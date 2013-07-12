<?php

/**
 * @author Nick Matantsev <nick.matantsev@gmail.com>
 * @copyright Copyright (c) 2013, Nick Matantsev
 */

namespace TodoApp;

class ActionContext extends \Fxrm\Action\Context {
    private $store;

    function __construct() {
        $this->store = new \Fxrm\Store\Environment(__DIR__ . '/store.json');

        parent::__construct(array(
            'TodoApp\\Email' => new \Fxrm\Action\ValueSerializer(),
            'TodoApp\\UserId' => new \Fxrm\Action\StoreIdSerializer($this->store)
        ), array(
            'TodoApp\\ApplicationException' => function ($e) {
                // return local class name of the exception
                return substr(get_class($e), strlen('TodoApp\\'));
            }
        ));
    }

    function getStore() {
        return $this->store;
    }
}

?>
