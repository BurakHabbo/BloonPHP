<?php

namespace Emulator\HabboHotel\Guilds;

use Emulator\HabboHotel\Guilds\GuildPartType;
use Emulator\HabboHotel\Guilds\GuildPart;
use Emulator\Emulator;
use Ubench;

class GuildManager {

    private $guildParts;
    private $guilds;

    public function __construct() {
        $bench = new Ubench();
        $bench->start();

        $this->guildParts = array();
        $this->guilds = array();
        $this->loadGuildParts();

        $bench->end();
        Emulator::getLogging()->logStart("Guild Manager -> Loaded! (" . $bench->getTime() . ")");
    }

    public function loadGuildParts() {
        unset($this->guildParts);

        foreach (GuildPartType::values() as $t) {
            $this->guildParts[$t] = array();
        }

        $query = Emulator::getDatabase()->query("SELECT * FROM guilds_elements;");

        foreach ($query as $elem) {
            $this->guildParts[strtoupper($elem->type)][$elem->id] = new GuildPart($elem);
        }
    }

}
