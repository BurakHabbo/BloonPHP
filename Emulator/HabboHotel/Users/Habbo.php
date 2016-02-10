<?php

namespace Emulator\HabboHotel\Users;

use Thread;

class Habbo extends Thread {

    private $client = null;
    private $habboInfo;
    private $habboStats;
    private $messenger;
    private $habboInventory;
    private $roomUnit;
    private $update;
    private $disconnected = false;
    private $disconnectig = false;

    public function __construct($set) {
        
    }

}
