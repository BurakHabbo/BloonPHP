<?php

namespace Emulator\Util\Pathfinding;

class Rotation {

    public static function calculate(int $X1, int $Y1, int $X2, int $Y2) {
        $rotation = 0;
        if ($X1 > $X2 && $Y1 > $Y2) {
            $rotation = 7;
        } else if ($X1 < $X2 && $Y1 < $Y2) {
            $rotation = 3;
        } else if ($X1 > $X2 && $Y1 < $Y2) {
            $rotation = 5;
        } else if ($X1 < $X2 && $Y1 > $Y2) {
            $rotation = 1;
        } else if ($X1 > $X2) {
            $rotation = 6;
        } else if ($X1 < $X2) {
            $rotation = 2;
        } else if ($Y1 < $Y2) {
            $rotation = 4;
        } else if ($Y1 > $Y2) {
            $rotation = 0;
        }
        return $rotation;
    }

}
