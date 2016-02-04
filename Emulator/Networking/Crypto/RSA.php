<?php

namespace Emulator\Networking\Crypto;

use Emulator\Networking\Crypto\BigInteger;

class RSA {

    private $n;
    private $e;
    private $d;
    private $p;
    private $q;
    private $dmp1;
    private $dmq1;
    private $coeff;
    private $canDecrypt;
    private $canEncrypt;
    private $fullByte;
    private $randomByte;

    public function __construct() {
        $this->n = 0;
        $this->e = 0;
        $this->d = 0;
        $this->p = 0;
        $this->q = 0;
        $this->dmp1 = 0;
        $this->dmq1 = 0;
        $this->coeff = 0;
        $this->canDecrypt = false;
        $this->canEncrypt = false;
        $this->fullByte = 1;
        $this->randomByte = 2;
    }

    public function setPrivate($n, $e, $d) {
        $n = str_replace("\r", "", $n);
        $n = str_replace("\n", "", $n);
        $e = str_replace("\r", "", $e);
        $e = str_replace("\n", "", $e);
        $d = str_replace("\r", "", $d);
        $d = str_replace("\n", "", $d);

        $this->n = new BigInteger($n, 16);
        $this->e = new BigInteger($e, 16);
        $this->d = new BigInteger($d, 16);
        $this->canEncrypt = true;
        $this->canDecrypt = true;
    }

    private function encode($string) {
        $ascii = array();
        $string_array = str_split($string);

        for ($i = 0; $i < count($string_array); $i++) {
            $char = ord($string_array[$i]);
            $ascii[$i] = $char;
        }

        return $ascii;
    }

    public static function toHexInteger($array) {
        $result = "";
        foreach ($array as $int) {
            $tmp = dechex($int);
            if (strlen($tmp) == 1)
                $tmp = "0" . $tmp;
            $result .= $tmp;
        }
        return new BigInteger($result, 16);
    }

    private function getBlockSize() {
        return floor((strlen($this->n->toString(16))) / 2);
    }

    private function doPrivate($x) {
        if ($this->canDecrypt) {
            return $x->modPow($this->d, $this->n);
        }
        return 0;
    }

    private function pkcs1pad($d, $n, $type) {
        $data = $this->encode($d);
        $out = array();
        for ($x = 0; $x < $n; $x++) {
            $out[$x] = 0;
        }

        $p = 0;
        $i = count($data) - 1;
        while ($i >= $p && $n > 11) {
            $out[--$n] = $data[$i--];
        }
        $out[--$n] = 0;

        while ($n > 2) {
            $out[--$n] = 0xFF;
        }

        $out[--$n] = 1; //type 1 = 0xFF, 2 = random
        $out[--$n] = 0;
        return $this->toHexInteger($out);
    }

    private function pkcs1unpad($d, $n, $type) {
        $b = BigInteger::toByteArray($d);
        $i = 0;

        while ($i < count($b) && $b[$i] == 0)
            ++$i;
        if (count($b) - $i != $n - 1 || $b[$i] != 2)
            return null;
        ++$i;
        while ($b[$i] != 0) {
            if (++$i >= count($b))
                return null;
        }
        $result = "";
        while (++$i < count($b)) {
            $c = $b[$i] & 255;
            if ($c < 128) {
                $result.= chr($c);
            } else if (($c > 191) && ($c < 224)) {
                $result.= chr((($c & 31) << 6) | ($b[$i + 1] & 63));
                ++$i;
            } else {
                $result.= chr((($c & 15) << 12) | (($b[$i + 1] & 63) << 6) | ($b[$i + 2] & 63));
                $i += 2;
            }
        }
        return $result;
    }

    public function verify($bytes) {
        $c = new BigInteger($bytes, 16);
        $m = $this->doPrivate($c);
        return $this->pkcs1unpad($m, $this->getBlockSize(), $this->fullByte);
    }

    public function sign($bytes) {
        $m = $this->pkcs1pad($bytes, $this->getBlockSize(), $this->fullByte);
        $c = $this->doPrivate($m);
        return $c->toString(16);
    }

}
