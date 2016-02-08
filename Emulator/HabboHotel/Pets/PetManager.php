<?php

namespace Emulator\HabboHotel\Pets;

use Emulator\HabboHotel\Pets\PetRace;
use Emulator\HabboHotel\Pets\PetData;
use Emulator\HabboHotel\Pets\PetVocal;
use Emulator\HabboHotel\Pets\PetCommand;
use Emulator\HabboHotel\Pets\PetVocalsType;
use Emulator\Emulator;
use Ubench;

class PetManager {

    public static $experiences = array(100, 200, 400, 600, 900, 1300, 1800, 2400, 3200, 4300, 5700, 7600, 10100, 13300, 17500, 23000, 30200, 39600, 51900);
    private $petRaces;
    private $petData;

    public function __construct() {
        $bench = new Ubench();
        $bench->start();

        $this->petRaces = array();
        $this->petData = array();
        $this->loadRaces();
        $this->loadPetData();
        $this->loadPetCommands();

        $bench->end();
        Emulator::getLogging()->logStart("Pet Manager -> Loaded! (" . $bench->getTime() . ")");
    }

    private function loadRaces() {
        $query = Emulator::getDatabase()->query("SELECT * FROM pet_breeds ORDER BY race, color_one ASC;");

        foreach ($query as $race) {
            if (!isset($this->petRaces[(int) $race->race])) {
                $this->petRaces[(int) $race->race] = array();
            }

            $this->petRaces[(int) $race->race][] = new PetRace($race);
        }
    }

    private function loadPetData() {
        $query = Emulator::getDatabase()->query("SELECT * FROM pet_actions ORDER BY pet_type ASC;");

        foreach ($query as $data) {
            $this->petData[(int) $data->pet_type] = new PetData($data);
        }

        $this->loadPetItems();
        $this->loadPetVocals();
    }

    private function loadPetItems() {
        $query = Emulator::getDatabase()->query("SELECT * FROM pet_items;");

        foreach ($query as $item) {
            $baseItem = Emulator::getGameEnvironment()->getItemManager()->getItem((int) $item->item_id);

            if ($baseItem == null) {
                continue;
            }
        }
    }

    private function loadPetVocals() {
        $query = Emulator::getDatabase()->query("SELECT * FROM pet_vocals;");

        foreach ($query as $vocal) {
            if ((int) $vocal->pet_id > 0) {
                $this->petData[(int) $vocal->pet_id][(string) new PetVocalsType(strtoupper($vocal->type))][] = new PetVocal($vocal->message);
                continue;
            }
            if (!isset(PetData::$generalPetVocals[(string) new PetVocalsType(strtoupper($vocal->type))])) {
                PetData::$generalPetVocals[(string) new PetVocalsType(strtoupper($vocal->type))] = array();
            }

            PetData::$generalPetVocals[(string) new PetVocalsType(strtoupper($vocal->type))][] = new PetVocal($vocal->message);
        }
    }

    private function loadPetCommands() {
        $commandsList = array();

        $query = Emulator::getDatabase()->query("SELECT * FROM pet_commands_data;");

        foreach ($query as $command) {
            $commandsList[(int) $command->command_id] = new PetCommand($command);
        }

        $query = Emulator::getDatabase()->query("SELECT * FROM pet_commands ORDER BY pet_id ASC;");

        foreach ($query as $command) {
            $this->petData[(int) $command->pet_id]->petCommands[] = $commandsList[(int) $command->command_id];
        }
    }

}
