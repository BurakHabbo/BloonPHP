<?php

namespace Emulator\HabboHotel\Users;

use Emulator\Messages\ServerMessage;
use Thread;

abstract class HabboItem extends Thread {

    private $id;
    private $userId;
    private $roomId;
    private $baseItem;
    private $wallPosition;
    private $x;
    private $y;
    private $z;
    private $rotation;
    private $extradata;
    private $limitedStack;
    private $limitedSells;
    private $needsUpdate = false;
    private $needsDelete = false;

    public function __construct($set, $baseItem, $item = null, $extradata = "", $limitedStack = 0, $limitedSells = 0) {
        if (is_object($set)) {
            $this->id = (int) $set->id;
            $this->userId = (int) $set->user_id;
            $this->roomId = (int) $set->room_id;
            $this->baseItem = $baseItem;
            $this->wallPosition = $set->wall_pos;
            $this->x = (int) $set->x;
            $this->y = (int) $set->y;
            $this->z = (float) $set->z;
            $this->rotation = (int) $set->rot;
            $this->extradata = (string) $set->extra_data;
            $this->limitedStack = (int) explode(":", $set->limited_data)[0];
            $this->limitedSells = (int) explode(":", $set->limited_data)[1];
        } else if (is_int($set)) {
            $id = $set;
            $userId = $baseItem;
            $this->id = (int) $id;
            $this->userId = (int) $userId;
            $this->roomId = 0;
            $this->baseItem = $item;
            $this->wallPosition = "";
            $this->x = 0;
            $this->y = 0;
            $this->z = (float) 0.0;
            $this->rotation = 0;
            $this->extradata = $extradata;
            $this->limitedSells = (int) $limitedSells;
            $this->limitedStack = (int) $limitedStack;
        }
    }

    public function serializeFloorData(ServerMessage $message) {
        $message->appendInt32($this->id);
        $message->appendInt32($this->baseItem->getSpriteId());
        $message->appendInt32($this->x);
        $message->appendInt32($this->y);
        $message->appendInt32($this->rotation);
        $message->appendString((string) $this->z);

        $message->appendString(($this->baseItem->allowWalk()) || true ? "" : "");
        //serverMessage.appendString((getBaseItem().allowWalk()) || ((getBaseItem().allowSit()) && (this.roomId != 0)) ? Item.getCurrentHeight(this) + "" : (getBaseItem().getInteractionType().getType() == InteractionTrophy.class) || (getBaseItem().getInteractionType().getType() == InteractionCrackable.class) || (getBaseItem().getName().toLowerCase().equals("gnome_box")) ? "1.0" : "");
    }

    public function serializeWallData(ServerMessage $message) {
        $message->appendString($this->id . "");
        $message->appendInt32($this->baseItem->getSpriteId());
        $message->appendString($this->wallPosition);

        if ($this instanceof $this) { //second this will be InteractionPostIt
            $message->appendString(explode(" ", $this->extradata)[0]);
        } else {
            $message->appendString($this->extradata);
        }

        $message->appendInt32($this->userId);
        $message->appendInt32(0); //serverMessage . appendInt32(Integer . valueOf((getBaseItem() . getStateCount() > 1) || ((this instanceof InteractionCrackable)) || ((this instanceof InteractionMultiHeight)) ? 1 : 0));
        $message->appendInt32(0);
    }

    public function serializeExtradata(ServerMessage $message) {
        if ($this->isLimited()) {
            $message->appendInt32($this->limitedSells);
            $message->appendInt32($this->limitedStack);
        }
    }

    public function isLimited() {
        return $this->limitedStack > 0;
    }

}
