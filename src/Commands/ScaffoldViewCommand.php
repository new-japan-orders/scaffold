<?php

namespace NewWorldOrders\Scaffold\Commands;

use Illuminate\Console\Command;
use NewWorldOrders\Scaffold\Stub;
use NewWorldOrders\Scaffold\ArgumentsTrait;

class ScaffoldViewCommand extends Command
{
    use ArgumentsTrait;

    /**
     * The console command name!
     *
     * @var string
     */
    protected $signature = 'scaffold:view {app_name} {model_name}';
    protected $views = [
        'index.stub' => 'index.blade.php',
        'create.stub' => 'create.blade.php',
        'edit.stub' => 'edit.blade.php',
        'show.stub' => 'show.blade.php',
    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new views.';

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
        
        $stub_dirpath = __DIR__.'/stubs/views/mvc/';
        $view_dirpath = resource_path('views/'.$this->app->singular_snake.'/'.$this->model->plural_snake.'/');
        if (!file_exists($view_dirpath)) {
            mkdir($view_dirpath, 0775, true);
        }
        foreach ($this->views as $stub_filename => $view_filename) {
            $contents = $this->compileStub($stub_dirpath.$stub_filename);
            Stub::copy($view_dirpath.$view_filename, $contents);
        }
    }
}
