<?php

namespace NewJapanOrders\Scaffold\Commands;

use Illuminate\Console\Command;
use NewJapanOrders\Arguments\CompilableArguments;

class ScaffoldAppCommand extends Command
{
    use CompilableArguments;

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

        $dirs[] = base_path($this->app->singular_snake);
        $dirs[] = base_path($this->app->singular_snake.'/Http/Controllers');
        $dirs[] = base_path($this->app->singular_snake.'/Policies');
        $dirs[] = resource_path('/views/' .$this->app->singular_snake);

        foreach ($dirs as $dir) {
            if (file_exists($dir)) {
                $this->comment("[Warning]{$dir} directory is already exists...skip");
            } else {
                mkdir($dir, 0775, true);
            }
        } 
    }
}
