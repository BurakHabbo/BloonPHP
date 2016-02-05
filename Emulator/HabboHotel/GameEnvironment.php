<?php

namespace Emulator\HabboHotel;

use Emulator\HabboHotel\Users\HabboManager;
use Emulator\HabboHotel\HotelView\HotelViewManager;
use Emulator\Emulator;

class GameEnvironment {

    private $habboManager;
    private $navigatorManager;
    private $guildManager;
    private $itemManager;
    private $catalogManager;
    private $hotelViewManager;
    private $roomManager;
    private $commandHandler;
    private $permissionsManager;
    private $botManager;
    private $modToolManager;
    private $petManager;
    private $achievementManager;
    private $guideManager;
    private $wordFilter;
    private $craftingManager;
    private $creditsScheduler;
    private $pixelScheduler;
    private $pointsScheduler;

    public function load() {
        Emulator::getLogging()->logStart("GameEnvironment -> Loading...");
        $this->habboManager = new HabboManager();
        $this->hotelViewManager = new HotelViewManager();
        Emulator::getLogging()->logStart("GameEnvironment -> Loaded!");
    }

}
