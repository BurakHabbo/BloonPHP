<?php

namespace Emulator\Util\Pathfinding;

use Emulator\HabboHotel\Rooms\Room;
use Emulator\HabboHotel\Rooms\RoomUnit;

class PathFinder {

    public static function getSquareInFront($x = 0, $y = 0, $rotation = 0, $offset = 1) {
        if (($rotation %= 8) == 0) {
            return new Tile($x, $y - $offset, 0.0);
        }
        if ($rotation == 1) {
            return new Tile($x + $offset, $y - $offset, 0.0);
        }
        if ($rotation == 2) {
            return new Tile($x + $offset, $y, 0.0);
        }
        if ($rotation == 3) {
            return new Tile($x + $offset, $y + $offset, 0.0);
        }
        if ($rotation == 4) {
            return new Tile($x, $y + $offset, 0.0);
        }
        if ($rotation == 5) {
            return new Tile($x - $offset, $y + $offset, 0.0);
        }
        if ($rotation == 6) {
            return new Tile($x - $offset, $y, 0.0);
        }
        if ($rotation == 7) {
            return new Tile($x - $offset, $y - $offset, 0.0);
        }
        return new Tile($x, $y, 0.0);
    }

}
