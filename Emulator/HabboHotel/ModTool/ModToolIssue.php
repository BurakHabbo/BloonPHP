<?php

namespace Emulator\HabboHotel\ModTool;

use Emulator\HabboHotel\ModTool\ModToolTicketState;
use Emulator\HabboHotel\ModTool\ModToolTicketType;

class ModToolIssue {

    private $id;
    private $state;
    private $type;
    private $category;
    private $timestamp;
    private $priority;
    private $reportedId;
    private $reportedUsername = "Uknown Reported Habbo";
    private $roomId;
    private $senderId;
    private $senderUsername = "Unknown Sender";
    private $modId = -1;
    private $modName = "";
    private $message = "Unknown Message";

    public function __construct($set) {
        $this->id = (int) $set->id;
        $this->state = new ModToolTicketState((int) $set->state);
        $this->timestamp = (int) $set->timestamp;
        $this->priority = (int) $set->score;
        $this->senderId = (int) $set->sender_id;
        $this->senderUsername = $set->sender_username;
        $this->reportedId = $set->reported_id;
        $this->reportedUsername = $set->reported_username;
        $this->message = $set->issue;
        $this->modId = (int) $set->mod_id;
        $this->modName = $set->mod_username;
        $this->type = new ModToolTicketType((int) $set->type);

        if ($this->modId <= 0) {
            $this->modName = "";
            $this->state = ModToolTicketState::OPEN;
        }
    }

}
