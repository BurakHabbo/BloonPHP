<?php

namespace Emulator\HabboHotel\ModTool;

class ModToolPreset {

    private $id;
    private $name;
    private $message;
    private $reminder;
    private $banLength;
    private $muteLength;

    public function __construct($set) {
        $this->id = (int) $set->id;
        $this->name = $set->name;
        $this->message = $set->message;
        $this->reminder = $set->reminder;
        $this->banLength = (int) $set->ban_for;
        $this->muteLength = (int) $set->mute_for;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getReminder() {
        return $this->reminder;
    }

    public function getBanLength() {
        return $this->banLength;
    }

    public function getMuteLength() {
        return $this->muteLength;
    }

}
