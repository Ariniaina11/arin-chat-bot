<?php

namespace Fakell\Bing\Clients;

use Fakell\Bing\MessageEvent;
use Ratchet\Client\WebSocket;
use Ratchet\Client\Connector;
use React\EventLoop\Loop;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ClientSocket
{
    private $url;
    private $loop;
    private $connector;
    private $websocket;
    private $pendingMessage = [];

    private EventDispatcherInterface $dispacther;

    public function __construct($url, EventDispatcherInterface $dispacther){
        $this->dispacther =$dispacther;
        $this->url = $url;
        $this->loop = Loop::get();
        $this->connector = new Connector($this->loop);
    }

    public function run(){
        $this->connector->__invoke($this->url)
            ->then(
                function (WebSocket $conn) {
                    $this->websocket = $conn;
                    $conn->on('message', function ($msg) {
                        $this->dispacther->dispatch(new MessageEvent($msg), "message");
                    });

                    $conn->on('close', function ($code = null, $reason = null) { 
                        if($_ENV["debug"])
                            echo "Connection closed (code {$code} - reason: {$reason})\n";
                        $this->stop();
                    });

                    foreach($this->pendingMessage as $msg){
                        $this->send($msg);
                    }
                },
                function (\Exception $e) {
                    echo "Unable to connect: {$e->getMessage()}\n";
                    $this->stop();
                }
            );

        $this->loop->run();
    }

    public function send(string $data){
        // If the connection is not yet established, queue the message
        if ($this->websocket === null) {
            if($_ENV["debug"])
                echo "Queuing message .\n";
            $this->pendingMessage [] = $data;
        } else {
            if($_ENV["debug"])
                echo "Sending message...\n";
            $this->websocket->send($data);
        }
    }

    public function stop(){
        if ($this->websocket !== null) {
            $this->websocket->close();
        }

        $this->loop->stop();
    }
}
