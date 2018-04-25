<?php

namespace NewWorldOrders\Scaffold\Commands;

use Illuminate\Console\Command;

class ScaffoldInitCommand extends Command
{
    /**
     * The console command name!
     *
     * @var string
     */
    protected $signature = 'scaffold:init {app_name} {model_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new App and Auth.';

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
        $app_name = $this->argument('app_name');
        $app_name = strtolower($app_name);
        $model_name = $this->argument('model_name');
        $model_name = strtolower($model_name);

        $this->call('scaffold:app', [
            'app_name' => $app_name
        ]);
        
        $this->call('scaffold:auth', [
            'app_name' => $app_name,
            'model_name' => $model_name,
        ]);
        
    }
}
