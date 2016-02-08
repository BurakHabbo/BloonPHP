<?php

namespace Emulator\Util\Pathfinding;

abstract class AbstractNode {

    const BASICMOVEMENTCOST = 10;
    const DIAGONALMOVEMENTCOST = 14;

    private $xPosition;
    private $yPosition;
    private $walkable;
    private $previous;
    private $diagonally;
    private $movementPanelty;
    private $gCosts;
    private $hCosts;

    protected function __construct(int $xPosition, int $yPosition) {
        $this->xPosition = $xPosition;
        $this->yPosition = $yPosition;
        $this->walkable = true;
        $this->movementPanelty = 0;
    }

    public function setIsDiagonaly(bool $isDiagonaly) {
        $this->diagonally = $isDiagonaly;
    }

    public function setCoordinates(int $x, int $y) {
        $this->xPosition = $x;
        $this->yPosition = $y;
    }

    public function getX() {
        return $this->xPosition;
    }

    public function getY() {
        return $this->yPosition;
    }

    public function isWalkable() {
        return $this->walkable;
    }

    public function setWalkable(bool $walkable) {
        $this->walkable = $walkable;
    }

    public function getPrevious() {
        return $this->previous;
    }

    public function setPrevious(AbstractNode $previous) {
        $this->previous = $previous;
    }

    public function setMovementPanelty(int $movementPanelty) {
        $this->movementPanelty = $movementPanelty;
    }

    public function getfCosts() {
        return $this->gCosts + $this->hCosts;
    }

    public function getgCosts() {
        return $this->gCosts;
    }

}
