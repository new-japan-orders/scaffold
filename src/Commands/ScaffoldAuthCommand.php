<?php

namespace NewJapanOrders\Scaffold\Commands;

use Illuminate\Console\Command;
use NewJapanOrders\Stub\Stub;
use NewJapanOrders\Scaffold\ArgumentsTrait;


class ScaffoldAuthCommand extends Command
{
    use ArgumentsTrait;

    /**
     * The console command name!
     *
     * @var string
     */
    protected $signature = 'scaffold:auth {app_name} {model_name}';

    protected $controllers = [
        'ForgotPasswordController.stub' => 'Auth/ForgotPasswordController.php', 
        'LoginController.stub' => 'Auth/LoginController.php',
        'RegisterController.stub' => 'Auth/RegisterController.php',
        'ResetPasswordController.stub' => 'Auth/ResetPasswordController.php',
        'Controller.stub' => 'Controller.php',
        'HomeController.stub' => 'HomeController.php',
    ];
    protected $views = [
        'home.stub' => 'home.blade.php',
        'auth/login.stub' => 'auth/login.blade.php',
        'auth/register.stub' => 'auth/register.blade.php',
        'auth/passwords/email.stub' => 'auth/passwords/email.blade.php',
        'auth/passwords/reset.stub' => 'auth/passwords/reset.blade.php',
        'layouts/app.stub' => 'layouts/app.blade.php',
    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Auth.';

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
 
        $this->copyControllers();
        $this->copyResources();
        $this->copyModel();
        $this->copyNotification();
        $this->copyMigrations(); 
        $this->copySeeder();
        $this->copyRoute();
    }

    protected function copyControllers()
    {
        $controller_path = $this->getControllerPath();
        if (!file_exists($controller_path.'/Auth')) {
            mkdir($controller_path.'/Auth', 0775, true);
        }
        foreach ($this->controllers as $stub_filepath => $php_filepath) {
            $contents = $this->compileStub(__DIR__.'/stubs/controllers/'.$stub_filepath);
            $php_filepath = $controller_path.'/'.$php_filepath;
            if (file_exists($php_filepath)) {
                $this->comment("[Warning]{$php_filepath} file is already exists...skip");
                continue;
            }
            Stub::copy($php_filepath, $contents);
        }
    }

    protected function copyResources()
    {
        $resouce_path = $this->getResourcePath();
        foreach ($this->views as $stub_filepath => $php_filepath) {
            $contents = $this->compileStub(__DIR__.'/stubs/views/'.$stub_filepath);
            $php_filepath = $resouce_path.'/'.$php_filepath;
            if (file_exists($php_filepath)) {
                $this->comment("[Warning]{$php_filepath} file is already exists...skip");
                continue;
            }   
            Stub::copy($php_filepath, $contents);
        }
    }

    protected function copyModel()
    {
        $model_dirpath = app_path('Models');
        if (!file_exists($model_dirpath)) {
            mkdir($model_dirpath, 0775, true);
        }
        $model_filepath = $model_dirpath.'/'.$this->model->singular_camel.'.php';
        if (file_exists($model_filepath)) {
            $this->comment("[Warning]{$model_filepath} file is already exists...skip");
        } else {   
            file_put_contents(
                $model_filepath,
                $this->compileStub(__DIR__.'/stubs/models/Model.stub')
            );
        }
    }

    protected function copyNotification()
    {
        $dirpath = base_path($this->app->singular_snake.'/Notifications');
        if (!file_exists($dirpath)) {
            mkdir($dirpath, 0775, true);
        }
        $filepath = $dirpath.'/ResetPassword.php';
        if (file_exists($filepath)) {
            $this->comment("[Warning]{$filepath} file is already exists...skip");
        } else {   
            file_put_contents(
                $filepath,
                $this->compileStub(__DIR__.'/stubs/notifications/ResetPassword.stub')
            );  
        } 
    }

    protected function copyMigrations()
    {
        $migrations = [
            base_path().'/database/migrations/2014_10_12_000000_create_'.$this->model->plural_snake.'_table.php' => __DIR__.'/stubs/migrations/2014_10_12_000000_create_model_table.stub',
            base_path().'/database/migrations/2014_10_12_100000_create_'.$this->model->singular_snake.'_password_resets_table.php' => __DIR__.'/stubs/migrations/2014_10_12_100000_create_password_resets_table.stub',
        ];

        foreach ($migrations as $migration_filepath => $stub_filepath) {
            if (file_exists($migration_filepath)) {
                $this->comment("[Warning]{$migration_filepath} file is already exists...skip");
            } else {   
                file_put_contents(
                    $migration_filepath,
                    $this->compileStub($stub_filepath)
                );
            }
        }
/*
        $migration_filepath = base_path().'/database/migrations/2014_10_12_000000_create_'.$this->model->plural_snake.'_table.php';
        if (file_exists($migration_filepath)) {
            $this->comment("[Warning]{$migration_filepath} file is already exists...skip");
        } else {   
            file_put_contents(
                $migration_filepath,
                $this->compileStub(__DIR__.'/stubs/migrations/2014_10_12_000000_create_model_table.stub')
            );
        }
*/
    }

    protected function copySeeder()
    {
        $seeder_filepath = base_path().'/database/seeds/'.$this->model->singular_camel.'Seeder.php';
        if (file_exists($seeder_filepath)) {
            $this->comment("[Warning]{$seeder_filepath} file is already exists...skip");
        } else {   
            file_put_contents(
                $seeder_filepath,
                $this->compileStub(__DIR__.'/stubs/seeds/ModelSeeder.stub')
            );
        }
    }

    protected function copyRoute()
    {
        file_put_contents(
            base_path('routes/'.$this->app->singular_snake.'.php'),
            $this->compileStub(__DIR__.'/stubs/routes.stub')
        ); 
    }

    protected function getControllerPath()
    {
        $dirpath = base_path($this->app->singular_snake.'/Http/Controllers/');
        return $dirpath;
    }

    protected function getResourcePath()
    {
        $resource_dirpath = resource_path('views/'.$this->app->singular_snake);
        if (file_exists($resource_dirpath.'/auth')) {
            $this->comment("[Warning]{$resource_dirpath}/auth directory is already exists...skip");
        } else {
            mkdir($resource_dirpath.'/auth');
        }
        if (file_exists($resource_dirpath.'/auth/passwords')) {
            $this->comment("[Warning]{$resource_dirpath}/auth/passwords directory is already exists...skip");
        } else {
            mkdir($resource_dirpath.'/auth/passwords');
        } 
        if (file_exists($resource_dirpath.'/layouts')) {
            $this->comment("[Warning]{$resource_dirpath}/layouts directory is already exists...skip");
        } else {
            mkdir($resource_dirpath.'/layouts');
        }
        return $resource_dirpath;
    }
}
