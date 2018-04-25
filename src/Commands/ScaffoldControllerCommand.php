<?php

namespace NewWorldOrders\Scaffold\Commands;

use Illuminate\Console\Command;
use NewWorldOrders\Scaffold\Stub;
use NewWorldOrders\Scaffold\ArgumentsTrait;

class ScaffoldControllerCommand extends Command
{
    use ArgumentsTrait;

    /**
     * The console command name!
     *
     * @var string
     */
    protected $signature = 'scaffold:controller {app_name} {model_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller.';

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
        
        $contents = $this->compileStub(__DIR__.'/stubs/controllers/MVCController.stub');

        $controller_dirpath = app_path($this->app->singular_camel.'/Http/Controllers');
        $controller_filepath = $controller_dirpath.'/'.$this->model->singular_camel.'Controller.php';
        Stub::copy($controller_filepath, $contents);
    }
}
