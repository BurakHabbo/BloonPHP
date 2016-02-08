<?php

namespace Emulator\HabboHotel\Rooms;

use Emulator\HabboHotel\Rooms\RoomTileState;
use Emulator\Util\Pathfinding\PathFinder;

class RoomLayout {

    private $name;
    private $doorX;
    private $doorY;
    private $doorZ;
    private $doorDirection;
    private $heightmap;
    private $map;
    private $mapSize;
    private $mapSizeX;
    private $mapSizeY;
    private $squareHeights;
    private $squareStates;
    private $heighestPoint;

    public function __construct($set) {
        $this->name = $set->name;
        $this->doorX = (int) $set->door_x;
        $this->doorY = (int) $set->door_y;
        $this->doorDirection = (int) $set->door_dir;
        $this->heightmap = $set->heightmap;
        $this->parse();
    }

    private function parse() {
        $modelTemp = explode("\n", str_replace("\r", "", $this->heightmap));
        $this->mapSize = 0;
        $this->mapSizeX = strlen($modelTemp[0]);
        $this->mapSizeY = count($modelTemp);

        $this->squareHeights = array();
        $this->squareStates = array();

        for ($y = 0; $y < $this->mapSizeY; $y++) {
            $this->squareHeights[$y] = array();
            $this->squareStates[$y] = array();
        }

        for ($y = 0; $y < $this->mapSizeY; $y++) {
            for ($x = 0; $x < $this->mapSizeX && strlen($modelTemp[$y]) == $this->mapSizeX; $x++) {
                $square = strtolower(substr($modelTemp[$y], $x, 1));
                if ($square == "x") {
                    $this->squareStates[$x][$y] = RoomTileState::BLOCKED;
                    $this->mapSize++;
                    continue;
                }

                $height = strlen($square) == 0 ? 0 : (is_numeric($square) ? (int) $square : 10 + array_search(strtoupper($square), str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ")));
                $this->squareStates[$x][$y] = RoomTileState::OPEN;
                $this->squareHeights[$x][$y] = $height;
                $this->mapSize++;

                if ($this->heighestPoint >= (float) $height)
                    continue;
                $this->heighestPoint = $height;
            }
        }

        foreach ($modelTemp as $mapLine) {
            $this->map .= $mapLine + "\r";
        }

        $doorFrontTile = PathFinder::getSquareInFront($this->doorX, $this->doorY, $this->doorDirection);
        if ($this->tileExists($doorFrontTile->X, $doorFrontTile->Y) && $this->squareStates[$doorFrontTile->X][$doorFrontTile->Y] != RoomTileState::BLOCKED && $this->doorZ != $this->squareHeights[$doorFrontTile->X][$doorFrontTile->Y]) {
            $this->doorZ = $this->squareHeights[$doorFrontTile->X][$doorFrontTile->Y];
            $this->squareStates[$this->doorX][$this->doorY] = $this->squareStates[$doorFrontTile->X][$doorFrontTile->Y];
            $this->squareHeights[$this->doorX][$this->doorY] = $this->squareStates[$doorFrontTile->X][$doorFrontTile->Y];
        }
    }

    public function tileExists(int $x, int $y) {
        return $x >= 0 && $y >= 0 && $x < $this->mapSizeX && $y < $this->mapSizeY;
    }

    public function tileWalkable(int $x, int $y) {
        return $this->tileExists($x, $y) && $this->squareStates[$x][$y] == RoomTileState::OPEN;
    }

}
