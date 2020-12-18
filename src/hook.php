<?php
use AutoBuild\BuildFile;

BuildFile::register_common_search_key('include', 'RegisterKey::register');
BuildFile::register_common_search_key('if', 'RegisterKey::register');
class RegisterKey
{
    public static function register($key, $replace_key, &$content, $value){
        $method_name = "action_{$key}";
        if(method_exists(RegisterKey::class, $method_name)){
            RegisterKey::$method_name($replace_key, $content, $value);
        }
    }

    public static function action_include($replace_key, &$content, $value){
        if(file_exists(TEMPLATE_PATH.$value)){
            $file_fd = fopen(TEMPLATE_PATH.$value, "r");
            $file_content = fread($file_fd, filesize(TEMPLATE_PATH.$value));
            fclose($file_fd);
            $content = str_replace($replace_key, $file_content, $content);
        }
    }

    public static function action_if($replace_key, &$content, $value){
        $rule = "/(?<fliter>[a-z_= 1-9]+) then ?(?<value>.+)/";
        preg_match($rule, "page == 1 then hello我", $matches);
        $filter_str = "return {$matches['fliter']};";
        if(eval($filter_str)){
            $content = str_replace($replace_key, $matches['value'], $content);
        }
    }
}


