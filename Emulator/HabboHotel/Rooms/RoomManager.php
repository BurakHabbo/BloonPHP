<?php

namespace Emulator\HabboHotel\Rooms;

use Emulator\HabboHotel\Rooms\RoomCategory;
use Emulator\HabboHotel\Rooms\RoomLayout;
use Emulator\HabboHotel\Rooms\Room;
use Emulator\Emulator;
use Ubench;

class RoomManager {

    private $roomCategories;
    private $roomLayouts;
    private $activeRooms;

    public function __construct() {
        $bench = new Ubench();
        $bench->start();

        $this->roomCategories = array();
        $this->roomLayouts = array();
        $this->activeRooms = array();
        $this->loadRoomCategories();
        $this->loadRoomModels();
        $this->loadPublicRooms();

        $bench->end();
        Emulator::getLogging()->logStart("Room Manager -> Loaded! (" . $bench->getTime() . ")");
    }

    private function loadRoomCategories() {
        unset($this->roomCategories);
        $this->roomCategories = array();

        $query = Emulator::getDatabase()->query("SELECT * FROM navigator_flatcats;");

        foreach ($query as $flatcat) {
            $this->roomCategories[] = new RoomCategory($flatcat);
        }
    }

    private function loadRoomModels() {
        unset($this->roomLayouts);
        $this->roomLayouts = array();

        $query = Emulator::getDatabase()->query("SELECT * FROM room_models;");

        foreach ($query as $model) {
            $this->roomLayouts[] = new RoomLayout($model);
        }
    }

    private function loadPublicRooms() {
        $query = Emulator::getDatabase()->query("SELECT * FROM rooms WHERE is_public = ? OR is_staff_picked = ? ORDER BY id DESC;", array("1", "1"));

        foreach ($query as $public) {
            $this->activeRooms[(int) $public->id] = new Room($public);
        }
    }

}
