<?php

namespace Emulator;

use Emulator\Core\Logging;
use Emulator\Threading\ThreadPooling;
use Emulator\Core\ConfigurationManager;
use Emulator\Core\TextsManager;
use Emulator\Core\CleanerThread;
use Emulator\Database\Database;
use Emulator\Networking\GameServer;
use Emulator\HabboHotel\GameEnvironment;
use Emulator\Util\Memory;
use Ubench;

class Emulator {

    public static $build = 1;
    public static $isReady = false;
    public static $stopped = false;
    private static $config;
    private static $texts;
    private static $gameServer;
    private static $rconServer;
    private static $database;
    private static $logging;
    private static $threading;
    private static $gameEnvironment;
    private static $pluginManager;
    public static $logo = "\r######                              ######  #     # ######   ###\n#     # #       ####   ####  #    # #     # #     # #     #  ###\n#     # #      #    # #    # ##   # #     # #     # #     #  ###\n######  #      #    # #    # # #  # ######  ####### ######    # \n#     # #      #    # #    # #  # # #       #     # #           \n#     # #      #    # #    # #   ## #       #     # #        ###\n######  ######  ####   ####  #    # #       #     # #        ###";

    public static function start() {
        try {
            $bench = new Ubench();
            $bench->start();
            self::$stopped = false;
            self::$logging = new Logging();
            self::$logging->logStart(self::$logo);
            self::$threading = new ThreadPooling(Memory::getAvailableProcessors() * 2 + 100);
            self::$config = new ConfigurationManager("config.ini");
            self::$database = new Database();
            self::$config->loadFromDatabase();
            self::$config->loaded = true;
            self::$texts = new TextsManager();
            //new CleanerThread()->start();
            self::$gameEnvironment = new GameEnvironment();
            self::$gameEnvironment->load();
            self::$gameServer = new GameServer(self::$config->getValue("game.host", "127.0.0.1"), self::$config->getInt("game.port", 3000), self::$logging);
            self::$gameServer->start();

            $bench->end();
            self::$logging->logStart("Habbo Hotel Emulator has succesfully loaded.");
            self::$logging->logStart("You're running: Version: 1.0");
            self::$logging->logStart("System launched in: " . $bench->getTime());
            self::$logging->logStart("PHP Max memory : " . Memory::getMaxMemory() . "GB, physical memory : " . Memory::getPhysicalMemory() . "GB");
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function getConfig() {
        return self::$config;
    }

    public static function getTexts() {
        return self::$texts;
    }

    public static function getGameServer() {
        return self::$gameServer;
    }

    public static function getRconServer() {
        return self::$rconServer;
    }

    public static function getDatabase() {
        return self::$database;
    }

    public static function getLogging() {
        return self::$logging;
    }

    public static function getThreading() {
        return self::$threading;
    }

    public static function getGameEnvironment() {
        return self::$gameEnvironment;
    }

    public static function getPluginManager() {
        return self::$pluginManager;
    }

    public static function getIntUnixTimestamp() {
        return time();
    }

}
