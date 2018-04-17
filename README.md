# scaffold

```
php artisan scaffold:init front user
php artisan scaffold:init admin admin
php artisan migrate
php artisan db:seed --class UserSeeder
php artisan db:seed --class AdminSeeder
```

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

``` app/Http/Middleware/RedirectIfAuthenticated.php

    public function handle($request, Closure $next, $guard = null)
    {   
        if (Auth::guard($guard)->check()) {
            return redirect($guard.'/home');
        }   

        return $next($request);
    }   

```

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
