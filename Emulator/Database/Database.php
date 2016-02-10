<?php

namespace Emulator\Database;

use Emulator\Database\DatabasePool;
use PDO;

class Database {

    private $databasePool;

    public function __construct($configurationManager) {
        $this->databasePool = new DatabasePool($configurationManager);
        $this->databasePool->getConnection();
    }

    public function query($query, $params = array()) {
        $pool = $this->databasePool->getConnection();
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
        $pool = $this->databasePool->getConnection();
        $exec = $pool->prepare($query);
        return $exec->execute($params);
    }

}
