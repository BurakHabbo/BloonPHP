<?php

namespace Emulator\Messages;

use Emulator\Networking\Protocol\HabboEncoding;

class ServerMessage {

    private $packet;
    private $header;

    public function __construct(int $header) {
        $this->header = $header;
    }

    public function appendInt32(int $int) {
        $this->packet .= HabboEncoding::encodeByte32($int);
    }

    public function appendInt16(int $int) {
        $this->packet .= HabboEncoding::encodeByte16($int);
    }

    public function appendString(string $string) {
        $this->packet .= HabboEncoding::encodeString($string);
    }

    public function appendBytes(string $bytes) {
        $this->packet .= $bytes;
    }

    public function appendByte(int $byte) {
        $this->packet .= chr($byte);
    }

    public function appendBoolean(bool $bool) {
        $this->packet .= HabboEncoding::encodeBoolean($bool);
    }

    public function getHeader() {
        return $this->header;
    }

    public function get() {
        return HabboEncoding::encodeByte32(strlen($this->packet) + 2) . HabboEncoding::encodeByte16($this->header) . $this->packet;
    }

}
