<?php

namespace Emulator\Threading;

use Emulator\Threading\Runnable;
use Emulator\Emulator;
use Worker;
use Pool;

class ThreadPooling {

    private $threadPool;
    private $scheduledPool;
    private $canAdd;

    public function __construct(int $size) {
        $this->threadPool = new Pool($size, Worker::class, array());

        Emulator::getLogging()->logStart("Thread Pool -> Loaded!");
        $this->canAdd = true;
    }

    public function run(Worker $run, $delay = 0) {
        if ($delay == 0) {
            $this->threadPool->submit(new Worker());
        } else {
            
        }
    }

    public function getThreadPool() {
        return $this->threadPool;
    }

}
