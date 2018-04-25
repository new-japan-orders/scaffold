<?php

namespace NewWorldOrders\Scaffold\Commands;

use Illuminate\Console\Command;
use NewWorldOrders\Scaffold\ArgumentsTrait;

class ScaffoldAppCommand extends Command
{
    use ArgumentsTrait;

    /**
     * The console command name!
     *
     * @var string
     */
    protected $signature = 'scaffold:app {app_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new App.';

    public function __construct()
    {   
        parent::__construct();
    }   

    /** 
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getArguments();

        $controller_dirpath = app_path($this->app->singular_camel.'/Http/Controllers');
        if (file_exists($controller_dirpath)) {
            $this->error("[ERROR]{$controller_dirpath} directory is already exists...skip");
        } else {    
            mkdir($controller_dirpath, 0775, true);
        }
        
        $resource_dirpath = resource_path('/views/' .$this->app->singular_snake); 
        if (file_exists($resource_dirpath)) {
            $this->error("[ERROR]{$resource_dirpath} directory is already exists...skip");
        } else {
            mkdir($resource_dirpath);
        }
        
        
    }
}
