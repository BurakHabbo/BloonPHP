<?php

namespace Emulator\Database;

use Emulator\Emulator;
use PDO;
use PDOException;

class DatabasePool {

    public static $pool;

    public static function getConnection() {
        if (!isset(self::$pool)) {
            try {
                self::$pool = new PDO('mysql:host=' . Emulator::getConfig()->getValue("db.hostname") . ';dbname=' . Emulator::getConfig()->getValue("db.database"), Emulator::getConfig()->getValue("db.username"), Emulator::getConfig()->getValue("db.password"), array(PDO::ATTR_PERSISTENT => true));
            } catch (PDOException $e) {
                Emulator::getLogging()->logErrorLine("[DATABASE] " . $e->getMessage());
                die();
            }
        } else {
            return self::$pool;
        }
    }

}
