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
     * @return BasicUserInfo[]
     */
    abstract function findAllUsers();

    private $currentUserId;

    function __construct($session) {
        $sessionId = $this->findSessionByKey($session);

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
