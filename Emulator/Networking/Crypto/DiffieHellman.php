<?php

namespace Emulator\Networking\Crypto;

use Emulator\Networking\Crypto\BigInteger;
use Threaded;

class DiffieHellman extends Threaded {

    private $prime;
    private $generator;
    private $privateKey;
    private $publicKey;
    private $publicClientKey;
    private $sharedKey;

    public function generateDH($prime = "", $generator = "", $base = 10) {
        if ($prime != "") {
            $this->prime = new BigInteger($prime, $base);
        } else {
            //$this->prime = new BigInteger(gmp_strval(gmp_nextprime(gmp_init(DiffieHellman::GenerateRandomHexString(32), 16))));
            $this->prime = new BigInteger("114670925920269957593299136150366957983142588366300079186349531");
        }

        if ($generator != "") {
            $this->generator = new BigInteger($generator, $base);
        } else {
            //$this->generator = new BigInteger(gmp_strval(gmp_nextprime(gmp_init(DiffieHellman::GenerateRandomHexString(30), 16))));
            $this->generator = new BigInteger("1589935137502239924254699078669119674538324391752663931735947");
        }

        $this->privateKey = new BigInteger(DiffieHellman::GenerateRandomHexString(30), 16);

        if ($this->generator->compare($this->prime) == 1) {
            $temp = $this->prime;
            $this->prime = $this->generator;
            $this->generator = $temp;
        }

        $this->publicKey = $this->generator->modPow($this->privateKey, $this->prime);
    }

    public function generateSharedKey($clientkey, $base = 10) {
        $this->publicClientKey = new BigInteger($clientkey, $base);
        $this->sharedKey = $this->publicClientKey->modPow($this->privateKey, $this->prime);
    }

    public function getPublicKey($bytearray = false) {
        if ($bytearray)
            return BigInteger::toByteArray($this->publicKey);
        return $this->publicKey->toString();
    }

    public function getSharedKey($bytearray = false) {
        if ($bytearray)
            return BigInteger::toByteArray($this->sharedKey);
        return $this->sharedKey->toString();
    }

    public function getPrime($bytearray = false) {
        if ($bytearray)
            return BigInteger::toByteArray($this->prime);
        return $this->prime->toString();
    }

    public function getGenerator($bytearray = false) {
        if ($bytearray)
            return BigInteger::toByteArray($this->generator);
        return $this->generator->toString();
    }

    public static function generateRandomHexString($len) {
        $output = sha1(sha1(rand()) . md5(rand() . sha1(rand()))) . sha1(sha1(rand()) . md5(rand() . sha1(rand())));
        return substr($output, 0, $len);
    }

}
