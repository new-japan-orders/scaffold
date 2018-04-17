<?php

namespace NewWorldOrders\Scaffold\Commands;

use Illuminate\Console\Command;

class ScaffoldAuthCommand extends Command
{
    /**
     * The console command name!
     *
     * @var string
     */
    protected $signature = 'scaffold:auth {app_name} {model_name}';
    protected $app_name = '';
    protected $namespace = '';
    protected $model_name = '';
    protected $table_name = '';

    protected $controllers = [
        'ForgotPasswordController.stub' => 'ForgotPasswordController.php', 
        'LoginController.stub' => 'LoginController.php',
        'RegisterController.stub' => 'RegisterController.php',
        'ResetPasswordController.stub' => 'ResetPasswordController.php',
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
        $app_name = $this->argument('app_name');
        $this->app_name = strtolower($app_name);
        $this->namespace = ucfirst($this->app_name);
        
        $model_name = strtolower($this->argument('model_name'));
        $this->model_name = ucfirst($model_name);
        $this->table_name = str_plural($model_name);
        $this->camel_table_name = ucfirst($this->table_name);
        
        $this->copyControllers();
        $this->copyResources();
        $this->copyModel();
        $this->copyMigration(); 
        $this->copySeeder();
        file_put_contents(
            base_path('routes/web.php'),
            $this->compileStub(__DIR__.'/stubs/make/routes.stub'),
            FILE_APPEND
        );
        
    }

    protected function copyControllers()
    {
        $auth_controller_path = $this->getAuthControllerPath();
        foreach ($this->controllers as $stub_filepath => $php_filepath) {
            $contents = $this->compileStub(__DIR__.'/stubs/make/controllers/'.$stub_filepath);
            $php_filepath = $auth_controller_path.'/'.$php_filepath;
            if (file_exists($php_filepath)) {
                $this->error("[Error]{$php_filepath} file is already exists...skip");
                continue;
            }
            $this->copyStub($php_filepath, $contents);
        }

        $home_controller_path = $this->getHomeControllerPath().'/HomeController.php';
        if (file_exists($home_controller_path)) {
            $this->error("[Error]{$home_controller_path} file is already exists...skip");
        } else {
            $contents = $this->compileStub(__DIR__.'/stubs/make/controllers/HomeController.stub');
            $this->copyStub($home_controller_path, $contents);
        }
    }

    protected function copyResources()
    {
        $resouce_path = $this->getResourcePath();
        foreach ($this->views as $stub_filepath => $php_filepath) {
            $contents = $this->compileStub(__DIR__.'/stubs/make/views/'.$stub_filepath);
            $php_filepath = $resouce_path.'/'.$php_filepath;
            if (file_exists($php_filepath)) {
                $this->error("[Error]{$php_filepath} file is already exists...skip");
                continue;
            }   
            $this->copyStub($php_filepath, $contents);
        }
        
    }

    protected function copyModel()
    {
        $model_filepath = app_path().'/'.$this->model_name.'.php';
        if (file_exists($model_filepath)) {
            $this->error("[Error]{$model_filepath} file is already exists...skip");
        } else {   
            file_put_contents(
                $model_filepath,
                $this->compileStub(__DIR__.'/stubs/make/models/Model.stub')
            );
        }
    }

    protected function copyMigration()
    {
        $migration_filepath = base_path().'/database/migrations/2014_10_12_000000_create_'.$this->table_name.'_table.php';
        if (file_exists($migration_filepath)) {
            $this->error("[Error]{$migration_filepath} file is already exists...skip");
        } else {   
            file_put_contents(
                $migration_filepath,
                $this->compileStub(__DIR__.'/stubs/make/migrations/2014_10_12_000000_create_model_table.stub')
            );
        }
    }

    protected function copySeeder()
    {
        $seeder_filepath = base_path().'/database/seeds/'.$this->model_name.'Seeder.php';
        if (file_exists($seeder_filepath)) {
            $this->error("[Error]{$seeder_filepath} file is already exists...skip");
        } else {   
            file_put_contents(
                $seeder_filepath,
                $this->compileStub(__DIR__.'/stubs/make/seeds/ModelSeeder.stub')
            );
        }
    }

    protected function getAuthControllerPath()
    {
        $app_path = app_path('Http/Controllers/');
        $auth_dirpath = $app_path.$this->namespace.'/Auth';
        if (file_exists($auth_dirpath)) {
            $this->error("[Error]{$auth_dirpath} directory is already exists...skip");
        } else {
            mkdir($auth_dirpath);
        }
        return $auth_dirpath;
    }

    protected function getHomeControllerPath()
    {
        $app_path = app_path('Http/Controllers/');
        $home_dirpath = $app_path.$this->namespace;
        return $home_dirpath;
    }

    protected function getResourcePath()
    {
        $resource_dirpath = resource_path('views/'.$this->app_name);
        if (file_exists($resource_dirpath.'/auth')) {
            $this->error("[Error]{$resource_dirpath}/auth directory is already exists...skip");
        } else {
            mkdir($resource_dirpath.'/auth');
        }
        if (file_exists($resource_dirpath.'/auth/passwords')) {
            $this->error("[Error]{$resource_dirpath}/auth/passwords directory is already exists...skip");
        } else {
            mkdir($resource_dirpath.'/auth/passwords');
        } 
        if (file_exists($resource_dirpath.'/layouts')) {
            $this->error("[Error]{$resource_dirpath}/layouts directory is already exists...skip");
        } else {
            mkdir($resource_dirpath.'/layouts');
        }
        return $resource_dirpath;
    }

    protected function copyStub($php_filepath, $content)
    {
        file_put_contents(
            $php_filepath,
            $content
        );
    }

    protected function compileStub($stub_filepath)
    {
        $ret = str_replace(
            '{{app_name}}',
            $this->app_name,
            file_get_contents($stub_filepath)
        );
        $ret = str_replace(
            '{{namespace}}',
            $this->namespace,
            $ret
        );
        $ret = str_replace(
            '{{model_name}}',
            $this->model_name,
            $ret
        );
        $ret = str_replace(
            '{{table_name}}',
            $this->table_name,
            $ret
        );
        $ret = str_replace(
            '{{camel_table_name}}',
            $this->camel_table_name,
            $ret
        );

        return $ret;
    }
}
