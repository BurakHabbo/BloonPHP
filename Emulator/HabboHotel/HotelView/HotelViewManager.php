<?php

namespace Emulator\HabboHotel\HotelView;

use Emulator\HabboHotel\HotelView\HallOfFame;
use Emulator\HabboHotel\HotelView\NewsList;
use Emulator\Emulator;
use Ubench;

class HotelViewManager {

    private $hallOfFame;
    private $newsList;

    public function __construct() {
        $bench = new Ubench();
        $bench->start();

        $this->hallOfFame = new HallOfFame();
        $this->newsList = new NewsList();

        $bench->end();
        Emulator::getLogging()->logStart("Hotelview Manager -> Loaded! (" . $bench->getTime() . ")");
    }

    public function getHallOfFame() {
        return $this->hallOfFame;
    }

    public function getNewsList() {
        return $this->newsList;
    }

}
