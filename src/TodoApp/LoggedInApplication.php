<?php

namespace TodoApp;

abstract class LoggedInApplication extends \TodoApp\Application {
    /**
     * @return SessionId
     */
    abstract function findSessionByKey($key);

    /**
     * @return UserId
     */
    abstract function getSessionUserId(SessionId $sessionId);

    abstract function setUserEmail(UserId $userId, Email $email);

    /**
     * @return object[]
     */
    abstract function queryAllUsers();

    private $currentUserId;

    function __construct($sessionKey) {
        $sessionId = $this->findSessionByKey($sessionKey);

        // @todo validate session expiry
        if ( ! $sessionId) {
            throw new NotLoggedInException();
        }

        $this->currentUserId = $this->getSessionUserId($sessionId);
    }

    function setEmail(Email $email) {
        $this->setUserEmail($this->currentUserId, $email);
    }
}

?>
