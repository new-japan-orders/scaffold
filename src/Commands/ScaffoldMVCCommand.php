<?php

namespace NewJapanOrders\Scaffold\Commands;

use Illuminate\Console\Command;
use NewJapanOrders\Scaffold\ArgumentsTrait;

class ScaffoldMVCCommand extends Command
{
    use ArgumentsTrait;
    
    /**
     * The console command name!
     *
     * @var string
     */
    protected $signature = 'scaffold:mvc {app_name} {model_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new MVC.';

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
 
        $this->call('scaffold:controller', [
            'app_name' => $this->app->singular_snake,
            'model_name' => $this->model->singular_snake
        ]);        
        $this->call('scaffold:model', [
            'model_name' => $this->model->singular_snake
        ]);  
        $this->call('scaffold:view', [
            'app_name' => $this->app->singular_snake,
            'model_name' => $this->model->singular_snake
        ]);  
    }
}
