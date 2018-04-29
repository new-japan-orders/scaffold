<?php

namespace NewJapanOrders\Scaffold;

use NewJapanOrders\Scaffold\Argument;

class Stub
{
    static function copy($php_filepath, $contents)
    {
        file_put_contents(
            $php_filepath,
            $contents
        );
    }

/*
    static function compileAll($stub_filepath, $args = [])
    {
        $contents = file_get_contents($stub_filepath);
        foreach ($args as $key => $arg) {
            $contents = self::compile($contents, $arg, $key);
        }

        return $contents;
    }
*/

    static function compile($contents, $key, $value)
    {
            $contents = str_replace(
                '{{'.$key.'}}',
                $value,
                $contents
            );  
        return $contents;
    }
}
