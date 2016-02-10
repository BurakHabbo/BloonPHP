<?php

namespace Emulator\Database;

use Emulator\Emulator;
use PDO;
use PDOException;

class DatabasePool {

    public static $pool;
    private $configurationManager;

    public function __construct($configurationManager) {
        $this->configurationManager = $configurationManager;
    }

    public function getConnection() {
        return new PDO('mysql:host=' . $this->configurationManager->getValue("db.hostname") . ';dbname=' . $this->configurationManager->getValue("db.database"), $this->configurationManager->getValue("db.username"), $this->configurationManager->getValue("db.password"), array(PDO::ATTR_PERSISTENT => true));
        if (!isset(DatabasePool::$pool)) {
            try {
                DatabasePool::$pool = new PDO('mysql:host=' . $this->configurationManager->getValue("db.hostname") . ';dbname=' . $this->configurationManager->getValue("db.database"), $this->configurationManager->getValue("db.username"), $this->configurationManager->getValue("db.password"), array(PDO::ATTR_PERSISTENT => true));
            } catch (PDOException $e) {
                Emulator::getLogging()->logErrorLine("[DATABASE] " . $e->getMessage());
                die();
            }
        } else {
            return DatabasePool::$pool;
        }
    }

}
