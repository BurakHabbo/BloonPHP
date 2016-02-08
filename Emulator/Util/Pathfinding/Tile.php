<?php

namespace Emulator\Util\Pathfinding;

class Tile {

    public $X;
    public $Y;
    public $Z;

    public function __construct(int $x = 0, int $y = 0, float $z = 0.0) {
        $this->X = (int) $x;
        $this->Y = (int) $y;
        $this->Z = (float) $z;
    }

    public static function getTilesAt(int $x, int $y, int $width, int $length, int $rotation) {
        $pointList = array();
        if ($rotation == 0 || $rotation == 4) {
            for ($i = $x; $i <= $x + ($width - 1); $i++) {
                for ($j = $y; $j <= $y + ($length - 1); $j++) {
                    $pointList[] = new Tile($i, $j, 0.0);
                }
            }

            return $pointList;
        } else {
            if ($rotation != 2 && $rotation != 6)
                return $pointList;
            for ($i = $x; $i <= $x + ($length - 1); $i++) {
                for ($j = $y; $j <= $y + ($width - 1); $j++) {
                    $pointList[] = new Tile($i, $j, 0.0);
                }
            }
        }
        return $pointList;
    }

    public function copy() {
        return new Tile($this->X, $this->Y, $this->Z);
    }

}
