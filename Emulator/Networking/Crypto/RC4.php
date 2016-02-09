<?php

namespace Emulator\Networking\Crypto;

use Threaded;

class RC4 extends Threaded {

    private $key;
    private $i;
    private $j;
    private $table;

    public function __construct() {
        $this->i = 0;
        $this->j = 0;
        $this->table = array();
    }

    public function init($key) {
        $this->key = $key;
        $k = count($this->key);

        while ($this->i < 256) {
            $this->table[$this->i] = $this->i;
            $this->i++;
        }
        $this->i = 0;
        $this->j = 0;
        while ($this->i < 256) {
            $this->j = ((($this->j + $this->table[$this->i]) + $this->key[($this->i % $k)]) % 256);
            $this->swap($this->i, $this->j);
            $this->i++;
        }
        $this->i = 0;
        $this->j = 0;
    }

    public function parse($bytes) {
        $k = 0;
        $result = "";
        for ($a = 0; $a < strlen($bytes); $a++) {
            $this->i = (($this->i + 1) % 256);
            $this->j = (($this->j + $this->table[$this->i]) % 256);
            $this->swap($this->i, $this->j);
            $result .= chr(ord($bytes[$a]) ^ $this->table[($this->table[$this->i] + $this->table[$this->j]) % 256]);
        }
        return $result;
    }

    private function swap($a, $b) {
        $k = $this->table[$a];
        $this->table[$a] = $this->table[$b];
        $this->table[$b] = $k;
    }

}
