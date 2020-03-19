# How to install laravel project

First, download the Laravel installer using Composer:

```
composer global require laravel/installer
```

path of composer

```
GNU / Linux Distributions: $HOME/.config/composer/vendor/bin or  $HOME/.composer/vendor/bin
```

then run command:

```
laravel new blog
```

another way is:

```
composer create-project --prefer-dist laravel/laravel blog
```

# What is contoller and how to use that

Controllers can group related request handling logic into a single class.

Controllers are stored in the `app/Http/Controllers` directory.

```
php artisan make:controller PhotoController --resource
```

In route:

```php
Route::resource('photos', 'PhotoController');
```

it will generate some methods

-   index()
-   create()
-   store()
-   show()
-   edit()
-   update()
-   destroy()
    you can also generate model

```
php artisan make:controller PhotoController --resource --model=Photo
```

When declaring a resource route, you may specify a subset of actions the controller should handle instead of the full set of default actions:

```php
Route::resource('photos', 'PhotoController')->only([
   'index', 'show'
]);

Route::resource('photos', 'PhotoController')->except([
   'create', 'store', 'update', 'destroy'
]);
```

## Resource Controllers

##Single Action Controllers
if you would like to define a controller that only handles a single action, you may place a single `__invoke` method on the controller

### how to create controller

```
php artisan make:controller ShowProfile --invokable
```

in controller:(showProfile.php)

```php
public function __invoke($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
```

in route:(web.php)

```php
Route::get('user/{id}', 'ShowProfile');
```

## Controller Middleware

In route:(web.php)

```php
Route::get('profile', 'UserController@show')->middleware('auth');
```

you can write in controller like

```php
public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('log')->only('index');

        $this->middleware('subscribed')->except('store');
    }
```

# use of middleware

Middleware provide a convenient mechanism for filtering HTTP requests entering your application
ex.If the user is not authenticated, the middleware will redirect the user to the login screen.
##How to create middleware

```
php artisan make:middleware CheckAge
```

it will store in `app/Http/Middleware`
then write condition in handle()

```php
public function handle($request, Closure $next)
    {
        if ($request->age <= 200) {
            return redirect('home');
        }

        return $next($request);
    }
```

after middleware create you should register into kernel file `app/Http/Kernel.php`

```php
protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
];
```

then you can use in router

```php
Route::get('admin/profile', function () {
    //
})->middleware('auth');
```

## Middleware Groups

Sometimes you may want to group several middleware under a single key to make them easier to assign to routes. You may do this using the `$middlewareGroups` property of your HTTP kernel.

Out of the box, Laravel comes with`web` and `api` middleware groups that contain common middleware you may want to apply to your web UI and API routes:

```php
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],

    'api' => [
        'throttle:60,1',
        'auth:api',
    ],
];
```

### how to call

```php
Route::get('/', function () {
    //
})->middleware('web');

Route::group(['middleware' => ['web']], function () {
    //
});

Route::middleware(['web', 'subscribed'])->group(function () {
    //
});
```

note:

```php
the web middleware group is automatically applied to your `routes/web.php` file by the RouteServiceProvider.
```

### how to pass parameter in middleware

in Middleware file

```php
 public function handle($request, Closure $next, $role)
    {
        if (! $request->user()->hasRole($role)) {
            // Redirect...
        }

        return $next($request);
    }
```

In route file

```php
Route::put('post/{id}', function ($id) {
    //
})->middleware('role:editor');
```

here pass `role` parameter which value is `editor`


# Use of model

```
php artisan make:model Flight
```

If you want with migration

```
php artisan make:model Flight -m
```

file generated into App folder

model.php

```php
class Flight extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'flight_id';
    public $incrementing = false;

    //If your primary key is not an integer, you should set the protected $keyType property on your model to string:

     protected $keyType = 'string';

     //expects created_at and updated_at columns

      public $timestamps = false;
      //customize the names of the columns used to store the timestamps,

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
//If you would like to specify a different connection for the model,
     protected $connection = 'connection-name';
}
```

SEtter and getter method are write into model 
also 
protected $fillable = ['user','title']; // only get which user and title filled data
protected $guarded = [];// get all column data  
protected $appends = []; // its use for getter methods


# How to make command in laravel

Generating Commands

```bash
php artisan make:command SendEmails
```

then write in app/Console/Commands like

```php
'commands' => [
    // App\Console\Commands\ExampleCommand::class,
],
```

after this make Mail and redirect into view file

Then go to app/console/commands/filename.php
write logic into handle()
