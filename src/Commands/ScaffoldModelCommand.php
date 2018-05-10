<?php

namespace NewJapanOrders\Scaffold\Commands;

use Illuminate\Console\Command;
use NewJapanOrders\Stub\Stub;
use NewJapanOrders\Scaffold\ArgumentsTrait;

class ScaffoldModelCommand extends Command
{
    use ArgumentsTrait;

    /**
     * The console command name!
     *
     * @var string
     */
    protected $signature = 'scaffold:model {model_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Model.';

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

        $this->call('make:model', [
            'name' => 'Models/'.$this->model->singular_camel,
            '--migration' => true,
        ]); 
        
        $this->call('make:factory', [
            'name' => $this->model->singular_camel.'Factory'
        ]);

        $this->call('make:seeder', [
            'name' => $this->model->singular_camel.'Seeder'
        ]);
    }
}
