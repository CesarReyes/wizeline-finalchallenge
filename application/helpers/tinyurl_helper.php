<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tinyurl{

    static function check_ulrs($lines){

        if(is_string($lines))
            $lines = explode("\n", $lines);
        
        if(!is_array($lines))
            return "Bad Urls list format";
        
        if(count($lines) > 40)
            return "Exceeds the 40 URLs limit";

        foreach($lines as $url){
            $url = trim($url);
            if($url){
                if (!self::check_ulr($url)) {
                    return "$url is not a valid URL";
                }

                //Check if is internal
                $parse_url = parse_url($url);
		        $parse_base = parse_url(base_url());
                if($parse_url['host'] && $parse_base['host']){
                    return "$url is not a valid URL";
                }
            }
        }

        return TRUE;
    }

    static function check_ulr($url){
        return preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url);
    }

    static function hash($url){
        return substr(strtolower(preg_replace('/[0-9_\/]+/','',base64_encode(sha1($url)))),0,10);
    }

    static function url($hash){
        return base_url("q/$hash");
    }
}

function debug_var($val){
   echo "<pre>";
   print_r($val);
   echo "</pre>";
}