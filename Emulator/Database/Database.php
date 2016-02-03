<?php

namespace Emulator\Database;

use Emulator\Database\DatabasePool;
use PDO;

class Database {

    public function __construct() {
        DatabasePool::getConnection();
    }

    public function query($query, $params = array()) {
        $pool = DatabasePool::getConnection();
        $exec = $pool->prepare($query);
        $exec->execute($params);
        $result = array();
        if ($exec->rowCount() > 0) {
            while ($query = $exec->fetch(PDO::FETCH_OBJ)) {
                $result[] = $query;
            }
        }
        return $result;
    }

    public function exec($query, $params = array()) {
        $pool = DatabasePool::getConnection();
        $exec = $pool->prepare($query);
        return $exec->execute($params);
    }

}
