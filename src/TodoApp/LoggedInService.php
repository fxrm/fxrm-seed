<?php

namespace TodoApp;

abstract class LoggedInService {
    /**
     * @return UserId
     */
    abstract function getSessionUserId(\Fxrm\Authentication\SessionId $session);

    abstract function setUserEmail(UserId $userId, Email $email);

    /**
     * @return object[]
     */
    abstract function queryAllUsers();

    private $currentUserId;

    function __construct(\Fxrm\Authentication\SessionManager $sessionManager, $sessionKey) {
        $sessionId = $sessionManager->accessSession($sessionKey, 3600);

        $this->currentUserId = $this->getSessionUserId($sessionId);
    }

    function setEmail(Email $email) {
        $this->setUserEmail($this->currentUserId, $email);
    }
}

?>
