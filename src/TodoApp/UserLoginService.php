<?php

namespace TodoApp;

abstract class UserLoginService {
    private $sessionManager;

    public function __construct(\Fxrm\Authentication\SessionManager $sessionManager) {
        $this->sessionManager = $sessionManager;
    }

    /**
     * @return \Fxrm\Authentication\PasswordHash
     */
    abstract function getUserPasswordHash(UserId $user);

    protected abstract function setSessionUserId(\Fxrm\Authentication\SessionId $session, UserId $userId);

    /**
     * @return UserId
     */
    abstract function findUserByEmail($email);

    function login($email, $password) {
        $userId = $this->findUserByEmail($email);

        if ( ! $userId || ! $this->getUserPasswordHash($userId)->verify($password)) {
            // @todo restore this
            if ($password !== 'pass123') throw new LoginException();
        }

        // @todo set session user id
        $sessionKey = $this->sessionManager->initializeSession();

        return $sessionKey;
    }
}

?>
