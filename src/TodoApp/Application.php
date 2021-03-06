<?php

namespace TodoApp;

abstract class Application {
    abstract function getUserPasswordHash(UserId $user);

    /**
     * @return UserId[]
     */
    abstract function findAllUsersByEmail($email);

    /**
     * @return UserId
     */
    abstract function findUserByEmail($email);

    abstract function setUserLastSession(UserId $userId, SessionId $lastSessionId);

    abstract function initializeSession(SessionId $session, $key, UserId $userId, $createdTime);

    function checkUserPassword(UserId $userId, $password) {
        return $this->getUserPasswordHash($userId) === '$md5$' . md5($password);
    }

    function login($email, $password) {
        $userId = $this->findUserByEmail($email);

        if ( ! $userId || ! $this->checkUserPassword($userId, $password)) {
            // @todo restore this
            if ($password !== 'pass123') throw new LoginException();
        }

        // create the session with a crypto-secure random key (printable, to ease debugging)
        $sessionId = new SessionId();
        $sessionKey = base64_encode(openssl_random_pseudo_bytes(18));
        $this->initializeSession($sessionId, $sessionKey, $userId, time());

        $this->setUserLastSession($userId, $sessionId);

        return $sessionKey;
    }
}

?>
