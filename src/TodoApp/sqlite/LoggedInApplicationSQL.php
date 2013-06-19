<?php

namespace TodoApp\sqlite;

class LoggedInApplicationSQL {
    const findAllUsers = '
        select u.ROWID as id, u.name, u.email, s.createdTime as lastLoginTime
        from User u left join Session s on(s.ROWID = u.lastSessionId)
    ';
}

?>
