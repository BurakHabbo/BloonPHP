<?php

namespace Emulator\HabboHotel;

use Emulator\HabboHotel\Users\HabboManager;
use Emulator\HabboHotel\HotelView\HotelViewManager;
use Emulator\HabboHotel\Guilds\GuildManager;
use Emulator\HabboHotel\Items\ItemManager;
use Emulator\HabboHotel\Catalog\CatalogManager;
use Emulator\HabboHotel\Rooms\RoomManager;
use Emulator\HabboHotel\Permissions\PermissionsManager;
use Emulator\HabboHotel\Bots\BotManager;
use Emulator\HabboHotel\ModTool\ModToolManager;
use Emulator\HabboHotel\Pets\PetManager;
use Emulator\HabboHotel\Achievements\AchievementManager;
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
        $this->guildManager = new GuildManager();
        $this->itemManager = new ItemManager();
        $this->itemManager->load();
        $this->catalogManager = new CatalogManager();
        $this->roomManager = new RoomManager();
        $this->permissionsManager = new PermissionsManager();
        $this->botManager = new BotManager();
        $this->modToolManager = new ModToolManager();
        $this->petManager = new PetManager();
        $this->achievementManager = new AchievementManager();
        Emulator::getLogging()->logStart("GameEnvironment -> Loaded!");
    }

    public function getHabboManager() {
        return $this->habboManager;
    }

    public function getNavigatorManager() {
        return $this->navigatorManager;
    }

    public function getGuildManager() {
        return $this->guildManager;
    }

    public function getItemManager() {
        return $this->itemManager;
    }

    public function getCatalogManager() {
        return $this->catalogManager;
    }

    public function getHotelViewManager() {
        return $this->hotelViewManager;
    }

    public function getRoomManager() {
        return $this->roomManager;
    }

    public function getCommandHandler() {
        return $this->commandHandler;
    }

    public function getPermissionsManager() {
        return $this->permissionsManager;
    }

    public function getBotManager() {
        return $this->botManager;
    }

    public function getModToolManager() {
        return $this->modToolManager;
    }

    public function getPetManager() {
        return $this->petManager;
    }

    public function getAchievementManager() {
        return $this->achievementManager;
    }

    public function getGuideManager() {
        return $this->guideManager;
    }

    public function getWordFilter() {
        return $this->wordFilter;
    }

    public function getCraftingManager() {
        return $this->craftingManager;
    }

    public function getCreditsScheduler() {
        return $this->creditsScheduler;
    }

    public function getPixelScheduler() {
        return $this->pixelScheduler;
    }

    public function getPointsScheduler() {
        return $this->pointsScheduler;
    }

}
