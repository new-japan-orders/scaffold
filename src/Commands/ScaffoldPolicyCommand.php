<?php

namespace NewWorldOrders\Scaffold\Commands;

use Illuminate\Console\Command;
use NewWorldOrders\Scaffold\Stub;
use NewWorldOrders\Scaffold\ArgumentsTrait;

class ScaffoldPolicyCommand extends Command
{
    use ArgumentsTrait;

    /**
     * The console command name!
     *
     * @var string
     */
    protected $signature = 'scaffold:policy {app_name} {auth_name} {model_name}';
    protected $auth_name;
    protected $auth_class_name;

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
        $this->getArguments();

        $contents = $this->compileStub(__DIR__.'/stubs/policies/ModelPolicy.stub');

        $policy_dirpath = base_path($this->app->singular_snake.'/Policies');
        if (!file_exists($policy_dirpath)) {
            mkdir($policy_dirpath, 0775, true); 
        }
        $policy_filepath = $policy_dirpath.'/'.$this->model->singular_camel.'Policy.php';
        Stub::copy($policy_filepath, $contents); 
    }
}
