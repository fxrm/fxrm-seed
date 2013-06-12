<?php

namespace Fxrm\Authentication;

abstract class SessionManager {
    /**
     * @return SessionId
     */
    function accessSession($sessionKey, $expirySeconds) {
        $session = $this->findSessionByKey($sessionKey);

        // validate session expiry
        $expiryTime = $session ? $this->getSessionAccessTime($session)->getTimestamp() : 0;

        if ($expiryTime < time() - $expirySeconds) {
            throw new NotLoggedInException();
        }

        // update latest access time
        $this->setSessionAccessTime($session, new \DateTime());

        return $session;
    }

    /**
     * @return string session key
     */
    function initializeSession() {
        // create the session with a crypto-secure random key (printable, to ease debugging)
        $sessionKey = base64_encode(openssl_random_pseudo_bytes(18)); // 18 bytes to avoid trailing "=" chars
        $time = new \DateTime();

        $session = $this->createSession($sessionKey, $time);

        // update latest access time
        $this->setSessionAccessTime($session, $time);

        return $sessionKey;
    }

    /**
     * @return SessionId
     */
    protected abstract function createSession($key, \DateTime $createdTime);

    /**
     * @return SessionId
     */
    protected abstract function findSessionByKey($key);

    /**
     * @return \DateTime
     */
    protected abstract function getSessionAccessTime(SessionId $session);

    protected abstract function setSessionAccessTime(SessionId $session, \DateTime $accessTime);
}

?>
