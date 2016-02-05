<?php

namespace Emulator\HabboHotel\HotelView;

use Emulator\HabboHotel\HotelView\NewsWidget;
use Emulator\Emulator;

class NewsList {

    private $newsWidgets;

    public function __construct() {
        $this->newsWidgets = array();
        $this->reload();
    }

    public function reload() {
        unset($this->newsWidgets);
        $this->newsWidgets = array();

        $query = Emulator::getDatabase()->query("SELECT * FROM hotelview_news ORDER BY id DESC LIMIT 10;");

        foreach ($query as $news) {
            $this->newsWidgets[] = new NewsWidget($news);
        }
    }

}
