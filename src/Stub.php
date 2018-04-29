<?php

namespace NewJapanOrders\Scaffold;

class Stub
{
    static function copy($php_filepath, $contents)
    {
        file_put_contents(
            $php_filepath,
            $contents
        );
    }

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
