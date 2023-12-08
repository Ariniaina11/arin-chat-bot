<?php
namespace Fakell\Bing;
use Fakell\Bing\Constant\Defaults;
use Fakell\Bing\Constant\Tones;
use Fakell\Bing\MessageEvent;
use Fakell\Bing\Utils\Formater;
use Fakell\Bing\Clients\Client;
use Fakell\Bing\Clients\ClientSocket;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Bing {

    private Client $client;
    private $conversation;
    private $convSignature;

    public function __construct(){
        $this->client = new Client;
        $this->debug();
    }

    public function debug($bool = false){
        $_ENV["debug"] = $bool;
    }
    private function create_conversation(){
        try {
            $res = $this->client->send("GET", "turing/conversation/create?bundleVersion=1.1199.4");
            $this->conversation = json_decode($res->getBody()->getContents(), true);
            $this->convSignature = $res->getHeaders()["X-Sydney-EncryptedConversationSignature"][0];
        } catch (GuzzleException $e) {
            throw new \Exception("Can't create conversation.\n\nReason : " . $e->getMessage());
        }
    }

    public function ask($query, $tones = Tones::BALANCED){
        
        if($_ENV["debug"])
            echo "Creating conversation...\n";
        $this->create_conversation();

        $req_id = md5(uniqid("", true));
        $ip_adress = rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255);
        $body = [
            "arguments" => [
                [
                    "source" => "cib",
                    "optionsSets" => Defaults::OPTIONS_SET ,
                    "allowedMessageTypes" => Defaults::ALLOWED_MESSAGE_TYPES,
                    "sliceIds" => [],
                    "verbosity" => "verbose",
                    "scenario" => "SERP",
                    "plugins" => [],
                    "traceId" => md5(uniqid("", true)),
                    "conversationHistoryOptionsSets" => Defaults::CONVERSATION_HISTORY_OPTIONS,
                    "isStartOfSession" => true,
                    "requestId" => $req_id,
                    "message" => [
                        "locationHints" => Defaults::LOCATION,
                        "userIpAddress" => $ip_adress,
                        "timestamp" => date('c', time()),
                        "author" => "user",
                        "inputMethod" => "Keyboard",
                        "text" => $query,
                        "messageType" => "Chat",
                        "requestId" => $req_id,
                        "messageId" => $req_id
                    ],
                    "tone" => $tones,
                    "spokenTextMode" => "None",
                    "conversationId" => $this->conversation["conversationId"],
                    "participant" => [
                        "id" => $this->conversation["clientId"]
                    ]
                ]
            ],
            "invocationId" => "0",
            "target" => "chat",
            "type" => 4
        ];

        if($_ENV["debug"])
            echo "Sending request...\n";
        $dispatcher = new EventDispatcher;
        $socketClient = new ClientSocket('wss://sydney.bing.com/sydney/ChatHub?sec_access_token=' . urlencode($this->convSignature), $dispatcher);
        $socketClient->send(Formater::format_message(json_encode(["protocol" => "json", "version" =>1])));
        $socketClient->send(Formater::format_message(json_encode($body)));

        $data = [];
        $dispatcher->addListener("message", function(MessageEvent $event) use (&$data, $socketClient){
            $d =  Formater::decode_message($event->getData());
            if(isset($d["arguments"][0]["messages"][0])){
                $data = $d["arguments"][0]["messages"][0];
                if(isset($data["suggestedResponses"])){
                    $socketClient->stop();
                }
            }
        });
        $socketClient->run();
        return $data;
    }
}