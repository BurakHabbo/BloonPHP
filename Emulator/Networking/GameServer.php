<?php

namespace Emulator\Networking;

use React\EventLoop\Factory;
use React\Socket\Server;
use Thread;
use Emulator\Emulator;
use Emulator\HabboHotel\GameClients\GameClientManager;

class GameServer extends Thread {

    private $host;
    private $port;
    private $server;
    private $sockets;
    private $gameClientManager;

    public function __construct(string $host, int $port) {
        $this->host = $host;
        $this->port = $port;
        $this->gameClientManager = new GameClientManager();
        $this->server = stream_socket_server("tcp://" . $this->host . ":" . $this->port, $errno, $errorMessage);
        stream_set_blocking($this->server, 0);
    }

    public function run() {
        $sockets = array();
        while (true) {
            $read_socks = $sockets;
            $read_socks[] = $this->server;
            if (!stream_select($read_socks, $write, $except, 300000)) {
                die('something went wrong while selecting');
            }

            if (in_array($this->server, $read_socks)) {
                $new_client = stream_socket_accept($this->server);
                stream_set_blocking($new_client, 0);
                if (is_resource($new_client)) {
                    list($ip, $port) = explode(":", stream_socket_get_name($new_client, true));
                    $this->gameClientManager->addClient((int) $new_client, $new_client, $ip, $port);
                    echo 'Connection accepted from ' . stream_socket_get_name($new_client, true) . "\n";
                    $sockets[] = $new_client;
                }
                unset($read_socks[array_search($this->server, $read_socks)]);
            }

            foreach ($read_socks as $sock) {
                $gameClient = $this->gameClientManager->getClient((int) $sock);
                $buffer = fread($sock, 4096);
                if (!$buffer) {
                    unset($sockets[array_search($sock, $sockets)]);
                    $this->gameClientManager->disposeClient((int) $sock);
                    echo "A client disconnected. Now there are total " . count($sockets) . " clients.\n";
                    continue;
                }

                if ($buffer == "<policy-file-request/>" . chr(0)) {
                    $gameClient->write('<?xml version="1.0"?><!DOCTYPE cross-domain-policy SYSTEM "/xml/dtds/cross-domain-policy.dtd"><cross-domain-policy><allow-access-from domain="*" to-ports="*" /></cross-domain-policy>' . chr(0));
                    continue;
                }
                $gameClient->write($data);
            }
        }
    }

}
