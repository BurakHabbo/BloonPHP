<?php

namespace Emulator\HabboHotel\Items;

use Emulator\Emulator;

class Item {

    private $id;
    private $spriteId;
    private $name;
    private $type;
    private $width;
    private $length;
    private $height;
    private $allowStack;
    private $allowWalk;
    private $allowSit;
    private $allowLay;
    private $allowRecyle;
    private $allowTrade;
    private $allowMarketplace;
    private $allowGift;
    private $allowInventoryStack;
    private $stateCount;
    private $effectM;
    private $effectF;
    private $vendingItems;
    private $multiHeights;
    private $interactionType;

    public function __construct($set) {
        $this->load($set);
    }

    public function reload($set) {
        $this->load($set);
    }

    public function load($set) {
        $this->id = (int) $set->id;
        $this->spriteId = (int) $set->sprite_id;
        $this->name = $set->item_name;
        $this->type = $set->type;
        $this->width = (int) $set->width;
        $this->length = (int) $set->length;
        $this->height = (float) $set->stack_height;
        $this->allowStack = (bool) $set->allow_stack == 1;
        $this->allowWalk = (bool) $set->allow_walk == 1;
        $this->allowSit = (bool) $set->allow_sit == 1;
        $this->allowLay = (bool) $set->allow_lay == 1;
        $this->allowRecyle = (bool) $set->allow_recycle == 1;
        $this->allowMarketplace = (bool) $set->allow_marketplace_sell == 1;
        $this->allowGift = (bool) $set->allow_gift == 1;
        $this->allowInventoryStack = (bool) $set->allow_inventory_stack == 1;

        $this->interactionType = Emulator::getGameEnvironment()->getItemManager()->getItemInteraction(strtolower($set->interaction_type));

        $this->stateCount = (int) $set->interaction_modes_count;
        $this->effectM = (int) $set->effect_id_male;
        $this->effectF = (int) $set->effect_id_female;

        if ($this->interactionType->getType() == null) { //null will be InteractionVendingMachine::class
            $this->vendingItems = array();

            foreach (explode(",", str_replace(";", ",", $set->vending_ids)) as $s) {
                $this->vendingItems[] = (int) str_replace(" ", "", $s);
            }
        }

        if ($this->interactionType->getType() == null) { //null will be InteractionMultiHeight::class
            $this->multiHeights = array();

            if (strpos($set->multiheight, ";") !== false) {
                foreach (explode(",", str_replace(";", ",", $set->multiheight)) as $s) {
                    $this->multiHeights[] = (float) str_replace(" ", "", $s);
                }
            }
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getSpriteId() {
        return $this->spriteId;
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getLength() {
        return $this->length;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getAllowStack() {
        return $this->allowStack;
    }

    public function getAllowWalk() {
        return $this->allowWalk;
    }

    public function getAllowSit() {
        return $this->allowSit;
    }

    public function getAllowLay() {
        return $this->allowLay;
    }

    public function getAllowRecyle() {
        return $this->allowRecyle;
    }

    public function getAllowTrade() {
        return $this->allowTrade;
    }

    public function getAllowMarketplace() {
        return $this->allowMarketplace;
    }

    public function getAllowGift() {
        return $this->allowGift;
    }

    public function getAllowInventoryStack() {
        return $this->allowInventoryStack;
    }

    public function getStateCount() {
        return $this->stateCount;
    }

    public function getEffectM() {
        return $this->effectM;
    }

    public function getEffectF() {
        return $this->effectF;
    }

    public function getVendingItems() {
        return $this->vendingItems;
    }

    public function getMultiHeights() {
        return $this->multiHeights;
    }

    public function getInteractionType() {
        return $this->interactionType;
    }

}
