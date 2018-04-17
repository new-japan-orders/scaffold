<?php

namespace NewWorldOrders\Scaffold\Commands;

use Illuminate\Console\Command;

class ScaffoldAppCommand extends Command
{
    /**
     * The console command name!
     *
     * @var string
     */
    protected $signature = 'scaffold:app {name?} {--default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a scaffold with bootstrap 3';

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
        $default = $this->option('default');
        $name = $this->argument('name');
        
        $names= [];
        if (!$default && !empty($name)) {
            $names[] = strtolower($name);
        } else {
            $names[] = 'front';
            $names[] = 'admin';
        }

        $app_path = app_path('Http/Controllers/');
        $resource_path = resource_path();

        foreach ($names as $name) {
            $controller_dirname = ucfirst($name);
            $controller_dirpath = $app_path . $controller_dirname;
            if (file_exists($controller_dirpath)) {
                $this->error("[ERROR]{$controller_dirpath} directory is already exists...skip");
            } else {    
                mkdir($controller_dirpath);
            }
            $resource_dirpath = $resource_path . '/views/' .$name; 
            //echo "{$resource_dirpath}\n"; 
            if (file_exists($resource_dirpath)) {
                $this->error("[ERROR]{$resource_dirpath} directory is already exists...skip");
            } else {
                mkdir($resource_dirpath);
            }
        }
    }
}
