<?php

namespace NewJapanOrders\Scaffold\Commands;

use Illuminate\Console\Command;
use NewJapanOrders\Stub\Stub;
use NewJapanOrders\Scaffold\ArgumentsTrait;

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

        $controller_dirpath = base_path($this->app->singular_snake.'/Http/Controllers');
        $controller_filepath = $controller_dirpath.'/'.$this->model->singular_camel.'Controller.php';

        if (file_exists($controller_filepath)) {
            $this->comment("[Warning]{$controller_filepath} file is already exists...skip");
        } else {
            $contents = $this->compileStub(__DIR__.'/stubs/controllers/MVCController.stub');
            Stub::copy($controller_filepath, $contents);
        }
    }
}
