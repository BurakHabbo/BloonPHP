<?php

namespace Emulator\HabboHotel\Users;

use Emulator\HabboHotel\Users\Habbo;
use Emulator\HabboHotel\GameClients\GameClient;
use Emulator\Emulator;
use Ubench;

require 'Emulator/HabboHotel/Users/Habbo.php';

class HabboManager {

    private $onlineHabbos;
    private $gameEnvironment;

    public function __construct($gameEnvironment) {
        $bench = new Ubench();
        $bench->start();

        $this->gameEnvironment = $gameEnvironment;
        $this->onlineHabbos = array();

        $bench->end();
        Emulator::getLogging()->logStart("Habbo Manager -> Loaded! (" . $bench->getTime() . ")");
    }

    public function addHabbo(Habbo $habbo) {
        $this->onlineHabbos[$habbo->getHabboInfo()->getId()] = $habbo;
    }

    public function removeHabbo(Habbo $habbo) {
        unset($this->onlineHabbos[$habbo->getHabboInfo()->getId()]);
    }

    public function getHabbo($search) {
        if (is_int($search)) {
            return $this->onlineHabbos[$search];
        } else if (is_string($search)) {
            foreach ($this->onlineHabbos as $habbo) {
                if (strtolower($habbo->getHabboInfo()->getUsername()) == strtolower($search)) {
                    return $habbo;
                }
            }
            return null;
        }
        return null;
    }

    public function loadHabbo(string $sso, GameClient $client) {
        $query = $this->gameEnvironment->getDatabase()->query("SELECT * FROM users WHERE auth_ticket = ? LIMIT 1;", array($sso));

        if (count($query) == 0) {
            return null;
        } else {
            $query = $query[0];
        }

        $h = $this->cloneCheck($query->username);
        if ($h != null) {
            
        }

        return new Habbo($query);
    }

    public function cloneCheck(string $username) {
        return $this->getHabbo($username);
    }

    public function getOnlineCount() {
        return count($this->onlineHabbos);
    }

}
