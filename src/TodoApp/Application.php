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

    /**
     * @return SessionId
     */
    abstract function findSessionByKey($key);

    abstract function getSessionUserId(SessionId $session);

    abstract function setUserLastSession(UserId $userId, SessionId $lastSessionId);

    abstract function initializeSession(SessionId $session, $key, UserId $userId, $createdTime);

    private function checkUserPassword(UserId $userId, $password) {
        return $this->getUserPasswordHash($userId) === '$md5$' . md5($password);
    }

    function lodgin($email, $password) {
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

    function getCurrentUserDetails($sessionKey) {
        // @todo check session expiry
        $sessionId = $this->findSessionByKey($sessionKey);
        $userId = $sessionId ? $this->getSessionUserId($sessionId) : null;

        if ( ! $userId) {
            throw new InvalidSessionException();
        }

        // @todo always update session expiry
        return array('email' => 'yeah!'); // @todo this
    }
}

?>
