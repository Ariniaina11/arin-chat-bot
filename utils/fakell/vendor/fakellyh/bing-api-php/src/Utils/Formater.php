<?php



namespace Fakell\Bing\Utils;

use Fakell\Bing\Constant\Defaults;

class Formater {


    public static function format_message(string $msg){
        return $msg . Defaults::DELIMITER;
    }

    public static function decode_message(string $msg){
        return json_decode(str_replace(Defaults::DELIMITER, "", $msg), true);
    }
}