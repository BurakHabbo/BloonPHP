<?php

namespace Emulator\HabboHotel\Items;

use Emulator\HabboHotel\Items\Interactions\InteractionDefault;
use Emulator\HabboHotel\Items\ItemInteraction;
use Emulator\HabboHotel\Items\CrackableReward;
use Emulator\HabboHotel\Items\SoundTrack;
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
        $this->loadCrackable();
        $this->loadSoundTracks();

        $bench->end();
        Emulator::getLogging()->logStart("Item Manager -> Loaded! (" . $bench->getTime() . ")");
    }

    public function loadItemInteractions() {
        $this->interactionsList[] = new ItemInteraction("default", InteractionDefault::class);
    }

    public function loadItems() {
        $query = Emulator::getDatabase()->query("SELECT * FROM items_base ORDER BY id DESC;");

        foreach ($query as $item) {
            $this->items[(int) $item->id] = new Item($item);
        }
    }

    public function loadCrackable() {
        unset($this->crackableRewards);

        $query = Emulator::getDatabase()->query("SELECT * FROM items_crackable;");

        foreach ($query as $item) {
            $this->crackableRewards[(int) $item->item_id] = new CrackableReward($item);
        }
    }

    public function loadSoundTracks() {
        unset($this->soundTracks);

        $query = Emulator::getDatabase()->query("SELECT * FROM soundtracks;");

        foreach ($query as $soundtrack) {
            $this->soundTracks[$soundtrack->code] = new SoundTrack($soundtrack);
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

    public function getItem($item) {
        if (is_int($item)) {
            return isset($this->items[$item]) ? $this->items[$item] : null;
        } else if (is_string($item)) {
            foreach ($this->items as $itm) {
                if (strtolower($itm->getName()) == strtolower($item)) {
                    return $itm;
                }
            }
            return null;
        }
        return null;
    }

}
