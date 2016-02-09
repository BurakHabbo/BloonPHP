<?php

namespace Emulator\HabboHotel\ModTool;

use Emulator\HabboHotel\ModTool\WordFilterWord;
use Emulator\Emulator;
use Ubench;

class WordFilter {

    private $autoReportWords;
    private $hideMessageWords;
    private $words;

    public function __construct() {
        $bench = new Ubench();
        $bench->start();

        $this->reload();

        $bench->end();
        Emulator::getLogging()->logStart("WordFilter -> Loaded! (" . $bench->getTime() . ")");
    }

    public function reload() {
        if (!Emulator::getConfig()->getBoolean("hotel.wordfilter.enabled")) {
            return;
        }

        unset($this->autoReportWords);
        unset($this->hideMessageWords);
        unset($this->words);
        $this->autoReportWords = array();
        $this->hideMessageWords = array();
        $this->words = array();

        $query = Emulator::getDatabase()->query("SELECT * FROM wordfilter;");

        foreach ($query as $word) {
            $word = new WordFilterWord($word);

            if ($word->isAutoReport()) {
                $this->autoReportWords[] = $word;
                continue;
            }

            if ($word->isHideMessage()) {
                $this->hideMessageWords[] = $word;
                continue;
            }

            $this->words[] = $word;
        }
    }

}
