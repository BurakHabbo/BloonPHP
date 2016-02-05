<?php

namespace Emulator\HabboHotel\HotelView;

use Emulator\HabboHotel\HotelView\HallOfFameWinner;
use Emulator\Emulator;

class HallOfFame {

    private $winners;
    private $competitionName;

    public function __construct() {
        $this->winners = array();
        $this->competitionName = "xmasRoomComp";
        $this->reload();
    }

    public function reload() {
        unset($this->winners);
        $this->winners = array();

        $query = Emulator::getDatabase()->query("SELECT users.look, users.username, users.id, users_settings.hof_points FROM users_settings INNER JOIN users ON users_settings.user_id = users.id WHERE hof_points > 0 ORDER BY hof_points DESC, users.id ASC LIMIT 10;");

        foreach ($query as $winner) {
            $winner = new HallOfFameWinner($winner);
            $this->winners[$winner->getId()] = $winner;
        }
    }

    public function getWinners() {
        return $this->winners;
    }

    public function getCompetitionName() {
        return $this->competitionName;
    }

    public function setCompetitionName($competitionName) {
        $this->competitionName = $competitionName;
    }

}
