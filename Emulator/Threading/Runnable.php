<?php

namespace Emulator\Threading;

use Worker;

interface Runnable {

    public function run();
}
