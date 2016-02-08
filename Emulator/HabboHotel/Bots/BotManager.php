<?php

namespace Emulator\HabboHotel\Bots;

use Emulator\HabboHotel\Bots\Bot;
use Emulator\Emulator;
use Ubench;

class BotManager {

    private $botDefenitions;

    public function __construct() {
        $bench = new Ubench();
        $bench->start();

        $this->botDefenitions = array();
        $this->botDefenitions["generic"] = Bot::class;
        $this->reload();

        $bench->end();
        Emulator::getLogging()->logStart("Bot Manager -> Loaded! (" . $bench->getTime() . ")");
    }

    public function reload() {
        foreach ($this->botDefenitions as $class) {
            new $class();
        }
    }

}
