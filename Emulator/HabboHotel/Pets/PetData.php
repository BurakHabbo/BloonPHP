<?php

namespace Emulator\HabboHotel\Pets;

use Emulator\HabboHotel\Pets\PetVocalsType;

class PetData {

    private $type;

    const BLINK = "eyb";
    const SPEAK = "spk";
    const EAT = "eat";
    const PLAYFUL = "pla";

    public $actionsHappy;
    public $actionsTired;
    public $actionsRandom;
    public $petCommands;
    private $nestItems;
    private $foodItems;
    private $drinkItems;
    public static $generalDrinkItems = array();
    public static $generalFoodItems = array();
    public static $generalNestItems = array();
    public $petVocals;
    public static $generalPetVocals = array();

    public function __construct($set) {
        $this->type = (int) $set->pet_type;
        $this->actionsHappy = explode(";", $set->happy_actions);
        $this->actionsTired = explode(";", $set->tired_actions);
        $this->actionsRandom = explode(";", $set->random_actions);
        $this->petCommands = array();
        $this->nestItems = array();
        $this->foodItems = array();
        $this->drinkItems = array();
        $this->petVocals = array();

        $this->petVocals[PetVocalsType::DISOBEY] = array();
        $this->petVocals[PetVocalsType::DRINKING] = array();
        $this->petVocals[PetVocalsType::EATING] = array();
        $this->petVocals[PetVocalsType::GENERIC_HAPPY] = array();
        $this->petVocals[PetVocalsType::GENERIC_NEUTRAL] = array();
        $this->petVocals[PetVocalsType::GENERIC_SAD] = array();
        $this->petVocals[PetVocalsType::GREET_OWNER] = array();
        $this->petVocals[PetVocalsType::HUNGRY] = array();
        $this->petVocals[PetVocalsType::LEVEL_UP] = array();
        $this->petVocals[PetVocalsType::MUTED] = array();
        $this->petVocals[PetVocalsType::PLAYFUL] = array();
        $this->petVocals[PetVocalsType::SLEEPING] = array();
        $this->petVocals[PetVocalsType::THIRSTY] = array();
        $this->petVocals[PetVocalsType::TIRED] = array();
        $this->petVocals[PetVocalsType::UNKNOWN_COMMAND] = array();

        if (count(PetData::$generalPetVocals) == 0) {
            PetData::$generalPetVocals[PetVocalsType::DISOBEY] = array();
            PetData::$generalPetVocals[PetVocalsType::DRINKING] = array();
            PetData::$generalPetVocals[PetVocalsType::EATING] = array();
            PetData::$generalPetVocals[PetVocalsType::GENERIC_HAPPY] = array();
            PetData::$generalPetVocals[PetVocalsType::GENERIC_NEUTRAL] = array();
            PetData::$generalPetVocals[PetVocalsType::GENERIC_SAD] = array();
            PetData::$generalPetVocals[PetVocalsType::GREET_OWNER] = array();
            PetData::$generalPetVocals[PetVocalsType::HUNGRY] = array();
            PetData::$generalPetVocals[PetVocalsType::LEVEL_UP] = array();
            PetData::$generalPetVocals[PetVocalsType::MUTED] = array();
            PetData::$generalPetVocals[PetVocalsType::PLAYFUL] = array();
            PetData::$generalPetVocals[PetVocalsType::SLEEPING] = array();
            PetData::$generalPetVocals[PetVocalsType::THIRSTY] = array();
            PetData::$generalPetVocals[PetVocalsType::TIRED] = array();
            PetData::$generalPetVocals[PetVocalsType::UNKNOWN_COMMAND] = array();
        }
    }

}
