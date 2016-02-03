<?php

namespace Emulator\Core;

use Emulator\Emulator;
use Thread;

class CleanerThread extends Thread {

    public static $DELAY = 10000;
    public static $RELOAD_HALL_OF_FAME = 1800;
    public static $RELOAD_NEWS_LIST = 3600;
    public static $REMOVE_INACTIVE_ROOMS = 120;
    public static $REMOVE_INACTIVE_GUILDS = 60;
    public static $REMOVE_INACTIVE_TOURS = 600;
    public static $SAVE_ERROR_LOGS = 30;
    private static $CALLBACK_TIME = 900;
    private static $LAST_HOF_RELOAD;
    private static $LAST_NL_RELOAD;
    private static $LAST_INACTIVE_ROOMS_CLEARED;
    private static $LAST_INACTIVE_GUILDS_CLEARED;
    private static $LAST_INACTIVE_TOURS_CLEARED;
    private static $LAST_ERROR_LOGS_SAVED;
    private static $LAST_CALLBACK;

    public function __construct() {
        self::$LAST_HOF_RELOAD = Emulator::getIntUnixTimestamp();
        self::$LAST_NL_RELOAD = Emulator::getIntUnixTimestamp();
        self::$LAST_INACTIVE_ROOMS_CLEARED = Emulator::getIntUnixTimestamp();
        self::$LAST_INACTIVE_GUILDS_CLEARED = Emulator::getIntUnixTimestamp();
        self::$LAST_INACTIVE_TOURS_CLEARED = Emulator::getIntUnixTimestamp();
        self::$LAST_ERROR_LOGS_SAVED = Emulator::getIntUnixTimestamp();
        self::$LAST_CALLBACK = Emulator::getIntUnixTimestamp();

        $this->databaseCleanup();
        $this->start();
    }

    public function run() {
        while (true) {
            sleep(30);
        }
    }

    public function databaseCleanup() {
        Emulator::getDatabase()->exec("UPDATE users SET online = ?;", array("0"));
        Emulator::getLogging()->logStart("Database -> Cleaned!");
    }

}
