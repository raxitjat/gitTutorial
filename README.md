# How to install laravel project

* First, download the Laravel installer using Composer:

```
composer global require laravel/installer
```

path of composer

```
GNU / Linux Distributions: $HOME/.config/composer/vendor/bin or  $HOME/.composer/vendor/bin
```

* Then run command:

```
laravel new blog
```

* Another way is:

```
composer create-project --prefer-dist laravel/laravel blog
```

# What is contoller and how to use that

* Controllers can group related request handling logic into a single class.

* Controllers are stored in the `app/Http/Controllers` directory.

```
php artisan make:controller PhotoController --resource
```

* In route:

```php
Route::resource('photos', 'PhotoController');
```

* It will generate some methods

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

* When declaring a resource route, you may specify a subset of actions the controller should handle instead of the full set of default actions:

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
* If you would like to define a controller that only handles a single action, you may place a single `__invoke` method on the controller

### how to create controller

```
php artisan make:controller ShowProfile --invokable
```

* In controller:(showProfile.php)

```php
public function __invoke($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
```

* In route:(web.php)

```php
Route::get('user/{id}', 'ShowProfile');
```

## Controller Middleware

* In route:(web.php)

```php
Route::get('profile', 'UserController@show')->middleware('auth');
```

* You can write in controller like

```php
public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('log')->only('index');

        $this->middleware('subscribed')->except('store');
    }
```

# Use of middleware

* Middleware provide a convenient mechanism for filtering HTTP requests entering your application
* ex.If the user is not authenticated, the middleware will redirect the user to the login screen.

##How to create middleware

```
php artisan make:middleware CheckAge
```

* It will store in `app/Http/Middleware`
* Then write condition in handle()

```php
public function handle($request, Closure $next)
    {
        if ($request->age <= 200) {
            return redirect('home');
        }

        return $next($request);
    }
```

* After middleware create you should register into kernel file `app/Http/Kernel.php`

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

* Then you can use in router

```php
Route::get('admin/profile', function () {
    //
})->middleware('auth');
```

## Middleware Groups

* Sometimes you may want to group several middleware under a single key to make them easier to assign to routes. You may do this using the `$middlewareGroups` property of your HTTP kernel.

*  Laravel comes with`web` and `api` middleware groups that contain common middleware you may want to apply to your web UI and API routes:

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

### How to call

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

* Note:

```php
the web middleware group is automatically applied to your `routes/web.php` file by the RouteServiceProvider.
```

### how to pass parameter in middleware

* In Middleware file

```php
 public function handle($request, Closure $next, $role)
    {
        if (! $request->user()->hasRole($role)) {
            // Redirect...
        }

        return $next($request);
    }
```

* In route file

```php
Route::put('post/{id}', function ($id) {
    //
})->middleware('role:editor');
```

* Here pass `role` parameter which value is `editor`


# Use of model

```
php artisan make:model Flight
```

* If you want with migration

```
php artisan make:model Flight -m
```

* File generated into App folder

Flight.php

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

* SEtter and getter method are write into model 
also 
* `protected $fillable = ['user','title']; // only get which user and title filled data`
* `protected $guarded = [];// get all column data  `
* `protected $appends = []; // its use for getter methods`

# What is Use of Storage 
* [usefull artical](https://laravel.com/docs/7.x/filesystem)

* Laravel provides a powerful filesystem abstraction.
* The filesystem configuration file is located at `config/filesystems.php`. Within this file you may configure all of your "disks".


To create the symbolic link, you may use the `storage:link `Artisan command:
```
php artisan storage:link
```
* After this command It will create folder `storage` into public folder

```php
Storage::disk('local')->put('file.txt', 'Contents');
```

* By Default `filesystems.php` file which `config/filsystems.php`


```php
'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

    ],
```
* You can change path according your requirement.

There are some useful methods or functions

```php
// The exists method may be used to determine if a file exists on the disk:
$exists = Storage::disk('s3')->exists('file.jpg');

//The missing method may be used to determine if a file is missing from the disk:
$missing = Storage::disk('s3')->missing('file.jpg');

//The download method accepts a file name as the second argument to the method, which will determine the file name that is seen by the user downloading the file
return Storage::download('file.jpg');

return Storage::download('file.jpg', $name, $headers);

 // If you are using the local driver, this will typically just prepend /storage to the given path and return a relative URL to the file.

$url = Storage::url('file.jpg');
//The put method may be used to store raw file contents on a disk.

Storage::put('file.jpg', $contents);

//delele 
Storage::delete('file.jpg');
```


# How upload Image
* Write into store method in controller

## How to Image store when data insert from form

```php
public function store(StorePostValidation $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->refrence = '123456';
        if ($imageFile = $request->file('image')) {

            $imageName = time() . '.' . $request->image->extension();
            $imagePath = $imageFile->store(config('custom.paths.postImage'));
            Storage::disk('public')->put(config('custom.paths.postImage') . $imageName, file_get_contents($imageFile));


            $post->image = $imageName;
        }


        $post->save();

        // session()->set('success','Item created successfully.');

        return redirect('/post')->with('success', 'Post is successfully saved');
    }
```


## How to update image or file
```php
  public function update(Request $request, $id)
    {
        $post = post::findOrFail($id);
        $imageFile = $request->file('image');
        $imageName = $post->image;

        if ($imageFile != '') {
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'description' => 'required|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if (Storage::disk('public')->exists(config('custom.paths.postImage') . $post->image)) {
                Storage::disk('public')->delete(config('custom.paths.postImage') . $post->image);

            }

            $imageName = time() . '.' . $request->image->extension();
            $imagePath = $imageFile->store(config('custom.paths.postImage'));
            Storage::disk('public')->put(config('custom.paths.postImage') . $imageName, file_get_contents($imageFile));


        } else {
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'description' => 'required|max:255',
            ]);
            

        }
        $form_data = array(
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName
        );
        Post::whereId($id)->update($form_data);

        return redirect('/post')->with('success', 'Post (' . $id . ') is successfully Updated');
    }

```






# How to make command in laravel

* Generating Commands

```bash
php artisan make:command SendEmails
```

* Then write in app/Console/Commands like

```php
'commands' => [
    // App\Console\Commands\ExampleCommand::class,
],
```

* After this make Mail and redirect into view file

* Then go to `app/console/commands/filename.php`
write logic into `handle()`
