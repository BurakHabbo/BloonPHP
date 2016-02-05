<?php

namespace Emulator\HabboHotel\Guilds;

class GuildPartType {

    private static $values = array("BASE", "SYMBOL", "BASE_COLOR", "SYMBOL_COLOR", "BACKGROUND_COLOR");

    public static function values() {
        return self::$values;
    }

}
