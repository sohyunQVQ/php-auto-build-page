<?php
use AutoBuild\BuildFile;

BuildFile::register_common_search_key('include', 'RegisterKey::register');

class RegisterKey
{
    public static function register($key, $replace_key, $content, $value){
        $method_name = "action_{$key}";
        if(method_exists(RegisterKey::class, $method_name)){
            $method_name($replace_key, $content, $value);
        }
    }

    public static function include($replace_key, $content, $value){
        if(file_exists(TEMPLATE_PATH.$value)){
            $file_fd = fopen(TEMPLATE_PATH.$value, "r");
            $file_content = fread($file_fd, filesize(TEMPLATE_PATH.$value));
            fclose($file_fd);
            $content = str_replace($replace_key, $file_content, $content);
        }
    }
}


