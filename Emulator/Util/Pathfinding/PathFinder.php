<?php

namespace Emulator\Util\Pathfinding;

use Emulator\HabboHotel\Rooms\Room;
use Emulator\HabboHotel\Rooms\RoomUnit;

class PathFinder {

    public static function getSquareInFront(int $x = 0, int $y = 0, int $rotation = 0, int $offset = 1): Tile {
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
