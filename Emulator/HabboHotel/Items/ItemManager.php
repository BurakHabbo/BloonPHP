<?php

namespace Emulator\HabboHotel\Items;

use Emulator\HabboHotel\Items\Interactions\InteractionDefault;
use Emulator\HabboHotel\Items\ItemInteraction;
use Emulator\HabboHotel\Items\Item;
use Emulator\Emulator;
use Ubench;

class ItemManager {

    private $items;
    private $crackableRewards;
    private $interactionsList;
    private $soundTracks;

    public function __construct() {
        $this->items = array();
        $this->crackableRewards = array();
        $this->interactionsList = array();
        $this->soundTracks = array();
    }

    public function load() {
        $bench = new Ubench();
        $bench->start();

        $this->loadItemInteractions();
        $this->loadItems();

        $bench->end();
        Emulator::getLogging()->logStart("Item Manager -> Loaded! (" . $bench->getTime() . ")");
    }

    public function loadItemInteractions() {
        $this->interactionsList[] = new ItemInteraction("default", InteractionDefault::class);
    }

    public function loadItems() {
        $query = Emulator::getDatabase()->query("SELECT * FROM items_base ORDER BY id DESC;");

        foreach ($query as $item) {
            $this->items[$item->id] = new Item($item);
        }
    }

    public function getItemInteraction($interactionName) {
        foreach ($this->interactionsList as $interaction) {
            if ($interaction->getName() == $interactionName) {
                return $interaction;
            }
        }
        //print("Not found interaction type : " . $interactionName . PHP_EOL);
        return $this->interactionsList[0];
    }

}
