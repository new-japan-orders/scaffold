# scaffold

## 概要

### 目的
フロントとバックエンドは分離したい。
けどアプリを2つ作るほどの規模じゃない。
なのでディレクトリで分離する。
中小規模でのCMS開発がターゲット。

### ディレクトリ構成
例えば以下のようにコマンドを実行した場合。
```
php artisan scaffold:init front user
```
ディレクトリ構成は以下のようになります。
```
base_path
├ app
│   ├ Models
│   │   └ User.php  
│   └ Front
│       └ Http
│           └ Controllers
│               ├ Controller.php
│               ├ HomeController.php
│               └ Auth
│                   ├ LoginController.php
│                   ├ ForgetController.php
│                   ├ RegisterController.php
│                   └ ResetController.php
│
├ resources
│   └ views
│       └ front
│           ├ home.blade.php
│           ├ layouts
│           │   └ app.blade.php
│           └ auth  
│               ├ login.blade.php
│               ├ register.blade.php
│               └ passwords
│                   ├ reset.blade.php
│                   └ email.blade.php
└ routes
    └ front.php
```

## init 
scaffold:initコマンドを利用すると、
前述のディレクトリ構成を作成した上で、
MultiAuthに必要なControllerやModelを用意できます。
このコマンドは、scaffold:appとscaffold:authを実行するのと同じ意味です。
```
php artisan scaffold:init front user
        ↑
<これらは同じ意味>
        ↓
php artisan scaffold:app front
php artisan scaffold:auth front user
```

### 使い方

#### コマンド実行例
```
php artisan scaffold:init front user
php artisan scaffold:init admin admin
php artisan migrate
php artisan db:seed --class UserSeeder
php artisan db:seed --class AdminSeeder
```
#### MultiAuthの設定
``` config/auth.php

return [
    'defaults' => [
        'guard' => 'front',
        'passwords' => 'users',
    ],
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],  
        'front' => [
            'driver' => 'session',
            'provider' => 'users',
        ],  
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Admin::class,
        ],


        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],
];

```
#### 認証済みの際のRedirect先修正
``` app/Http/Middleware/RedirectIfAuthenticated.php

    public function handle($request, Closure $next, $guard = null)
    {   
        if (Auth::guard($guard)->check()) {
            return redirect($guard.'/home');
        }   

        return $next($request);
    }   

```
#### 認証失敗時のリダイレクト先の修正
``` app/Exceptions/Handler.php

    protected function unauthenticated($request, AuthenticationException $exception)
    {   
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }   

        if (in_array('admin', $exception->guards())) {
            return redirect()->guest(route('admin.login'));
        }   
        return redirect()->guest(route('front.login'));
    } 

```
#### routeの設定
``` app/Providers/RouteServiceProvider.php
    protected function mapWebRoutes()
    {   
        $this->checkApp();
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path($this->route_file));
    }   

    protected function checkApp()
    {   
        $url = url()->current();
        if (strpos($url, 'front') !== false) {
            $this->namespace = 'App\Front\Http\Controllers';
            $this->route_file = 'routes/front.php';
        } else if (strpos($url, 'admin') !== false) {
            $this->namespace = 'App\Admin\Http\Controllers';
           $this->route_file = 'routes/admin.php';
        }   
    }   
```

## mvc
scaffold:mvcコマンドを利用すると、
前述のディレクトリ構成を作成した上で、
Model, Controller, Viewの3つを作成します。
このコマンドは、

* scaffold:controller
* scaffold:model
* scaffold:view

を実行するのと同じ意味です。
```
php artisan scaffold:mvc front user car
        ↑
<これらは同じ意味>
        ↓
php artisan scaffold:controller front car
php artisan scaffold:model car
php artisan scaffold:view front user car
```



