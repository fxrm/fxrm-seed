<?php

namespace Fxrm\Authentication;

class PasswordHash {
    private $hash;

    public function __construct($password) {
        $this->hash = password_hash($password, PASSWORD_DEFAULT);

        if ($this->hash === false) {
            throw new \Exception('error computing hash'); // developer error @todo custom exception class?
        }
    }

    public function verify($password) {
        return password_verify($this->hash, $password);
    }

    public function __toString() {
        return $this->hash;
    }
}

?>
