<?php

namespace Emulator\Networking\Crypto;

class BigInteger {

    private $str;

    public function __construct($str, $base = 10) {
        if ($base == 10) {
            $this->str = $str;
        } else if ($base == 16) {
            $this->str = BigInteger::bchexdec($str);
        }
    }

    public static function bchexdec($hex) {
        if (strlen($hex) == 1) {
            return hexdec($hex);
        } else {
            $remain = substr($hex, 0, -1);
            $last = substr($hex, -1);
            return bcadd(bcmul(16, BigInteger::bchexdec($remain)), hexdec($last));
        }
    }

    public static function bcdechex($dec) {
        $last = bcmod($dec, 16);
        $remain = bcdiv(bcsub($dec, $last), 16);

        if ($remain == 0) {
            return dechex($last);
        } else {
            return BigInteger::bcdechex($remain) . dechex($last);
        }
    }

    public function compare($to) {
        return bccomp($this->str, is_object($to) ? $to->toString() : $to);
    }

    public function modPow($exponent, $modulus) {
        return new BigInteger(bcpowmod($this->str, is_object($exponent) ? $exponent->toString() : $exponent, is_object($modulus) ? $modulus->toString() : $modulus));
    }

    public function toString($base = 10) {
        if ($base == 10) {
            return $this->str;
        } else if ($base == 16) {
            return BigInteger::bcdechex($this->str);
        }
    }

    public static function toByteArray($gmp) {
        $result = Array();
        $base16 = $gmp->toString(16);
        if (strlen($base16) % 2 != 0) {
            $base16 = "0" . $base16;
        }
        $hexs = str_split($base16, 2);
        foreach ($hexs as $hex) {
            $result[] = hexdec($hex);
        }
        return $result;
    }

}
