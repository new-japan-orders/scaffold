<?php

namespace NewJapanOrders\Scaffold;

use NewJapanOrders\Scaffold\Argument;
use NewJapanOrders\Scaffold\Stub;

trait ArgumentsTrait
{
    protected $app = null;
    protected $model = null;
    protected $auth = null;
    protected $prefixes = [
        'app', 'model', 'auth'
    ];

    protected function getArguments()
    {
        $args = $this->arguments();
        if (!empty($args['app_name'])) {
            $this->app = new Argument($args['app_name']);
        }   
        if (!empty($args['model_name'])) {
            $this->model = new Argument($args['model_name']);
        }   
        if (!empty($args['auth_name'])) {
            $this->auth = new Argument($args['auth_name']);
        }   
    }

    protected function compileStub($stub_filepath)
    {
        $contents = file_get_contents($stub_filepath);  
        foreach ($this->prefixes as $prefix) {
            if (is_null($this->$prefix)) {
                continue;
            }
            $args = (array)($this->$prefix);
            foreach ($args as $key => $arg) {
                $contents = Stub::compile($contents, $prefix.'_'.$key, $arg);
            }
        }
        
        return $contents;
    }
}
