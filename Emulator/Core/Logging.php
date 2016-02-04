<?php

namespace Emulator\Core;

class Logging {

    public function logStart(string $line) {
        print("[\033[1m\033[32mLOADING\033[0m] " . $line . PHP_EOL);
    }

    public function logErrorLine(string $line) {
        $line = str_replace("[", "[\033[1m\033[31m", $line);
        $line = str_replace("]", "\033[0m]", $line);
        print($line . PHP_EOL);
    }

    public function logPacketLine(string $line) {
        print("[\033[34mPACKET\033[0m]" . $line . PHP_EOL);
    }

}
