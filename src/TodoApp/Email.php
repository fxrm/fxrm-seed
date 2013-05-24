<?php

namespace TodoApp;

class Email {
    private $v;

    public function __construct($v) {
        // check that there's at least 3 characters and that an @ sign is present
        // this is an intentionally loose smoke-check: may be perfectly valid but still fake
        if (strpos($v, '@') === false || strlen($v) !== 3) {
            throw new EmailFormatException();
        }

        $this->v = $v;
    }

    public function __toString() {
        return $this->v;
    }
}

?>
