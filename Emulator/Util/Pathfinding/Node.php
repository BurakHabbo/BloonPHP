<?php

namespace Emulator\Util\Pathfinding;

use Emulator\Util\Pathfinding\AbstractNode;

class Node extends AbstractNode {

    public function __construct(int $xPosition, int $yPosition) {
        parent::__construct($xPosition, $yPosition);
    }

    private function absolute($n): int {
        return $n > 0 ? $n : -$n;
    }

}
