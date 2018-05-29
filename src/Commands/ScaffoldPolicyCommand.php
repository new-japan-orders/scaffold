<?php

namespace NewJapanOrders\Scaffold\Commands;

use Illuminate\Console\Command;
use NewJapanOrders\Stub\Stub;
use NewJapanOrders\Arguments\CompilableArguments;

class ScaffoldPolicyCommand extends Command
{
    use CompilableArguments;

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
    protected $description = 'Create a new Policy';

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

        $policy_dirpath = base_path($this->app->singular_snake.'/Policies');
        if (!file_exists($policy_dirpath)) {
            mkdir($policy_dirpath, 0775, true); 
        }

        $policy_filepath = $policy_dirpath.'/'.$this->model->singular_camel.'Policy.php';
        if (file_exists($policy_filepath)) {
            $this->comment("[Warning]{$policy_filepath} file is already exists...skip");
        } else {
            $contents = $this->compileStub(__DIR__.'/stubs/policies/ModelPolicy.stub');
            Stub::copy($policy_filepath, $contents); 
        }
    }
}
