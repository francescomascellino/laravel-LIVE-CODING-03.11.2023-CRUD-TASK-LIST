<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Initial steps

- connect the db
- link filesystem
- scaffold pacchetto
- create a layout
- crud ops

## Edit the .env file

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=your_mamp_mysql_port_number_here
DB_DATABASE=your_db_name_here
DB_USERNAME=root
DB_PASSWORD=root

```

## Link laravel filesystem

- edit .env
- edit config/filesystems.php
- run the artisan command

Edit the filesystem to use the ***public disk***
Set the variable to public as shown below

```env
FILESYSTEM_DISK=public

```

Edit the config file

```php

'default' => env('FILESYSTEM_DISK', 'public'),

```

run artisan storage link

```bash
php artisan storage:link
```

## Install the Laravel Preset

```bash
composer require pacificdev/laravel_9_preset
# run the command
php artisan preset:ui bootstrap
```

Before you can run the `npm` commands you need to apply the fix described in the docs of the package

### Compatibility notes

This package has been tested with both laravel 9.x and 10.x versions. However, from laravel v.10.10 the framework includes a 'type': 'module' property in the package.json file that was not used on previous versions.

Up to laravel v10.0
Install the package as described in the documentation above, no issues have been reported.

From Laravel v.10.10 and up
When you install the package following the documentation above and then run npm run dev it returns an error due to a `require('path')` used in the vite.config.js file.

If `require('path')` is replaced with import path from 'path' the dev server will return another error, mentioning the `laravel()` function being undefined. So, the import statement can be updated or not, it won't fix the issue.

To fix the issue you can:

- 1. remove from the laravel package.json file the `"type": "module"` or
- 2. rename the `vite.config.js` file to `vite.config.cjs`

### Run the npm commands

```bash
npm i
npm run dev
```

## Create App Layouts

- add an app.blade.php layout file for guests
- add an admin.blade.php layout file for admin users

Copy the welcome.blade.php file and place inside a folder called /layouts

```text

/layouts
 - app.blade.php
 - admin.blade.php

```

Remember to user the blade `@yield('content')` directive to add the placeholders for your pages contents.
And add also a yield for the page title `@yield('page-title', 'can accept a default value')`.

## CRUD Ops

- create Model
- create the migration for the given model
- create resource controller for the given model
- create resource routes
- implement the resource controller methods

### Create a Model

```bash
# create model/migration/seeder
php artisan make:model Lightsaber -ms
```

remember to define the migration and seeders to add some data to the db.
remember to edit .env to connect your db.

### Create Resource Controller

Create a resource controller called LightsabersController inside Admin/ folder (namespace)
and associates it to the Model

```bash
php artisan make:controller Admin/LightsabersController --resource --model=Lightsaber

```

### Create Route Resource

Inside web.php create a route resource for the model. Using the uri as its path and the created controler.

```php


// uri, Controller
Route::resource('admin/lightsabers', LightsabersController::class);

```

⚡ ATTENTION:
Remember to import the controller at the top of the web.php file.

```php
use App\Http\Controllers\Admin\LightsabersController;

//...

```

NOTE:
A route resource can be defined as single routes using all different methods.

```php
/* Versione estesa della route:resource('lightsabers', LightsabersController::class);

// READ
Route::get('/lightsabers', [LightsabersController::class, 'index'])->name('sabers.index');
//CRETE
Route::get('/lightsabers/create', [LightsabersController::class, 'create'])->name('sabers.create');
//CREATE
Route::post('/lightsabers', [LightsabersController::class, 'store'])->name('sabers.store');
//READ
Route::get('/lightsabers/{lightsaber}', [LightsabersController::class, 'show'])->name('sabers.show');

//UPDATE
Route::get('/lightsabers/{lightsaber}/edit', [LightsabersController::class, 'edit'])->name('sabers.edit');

Route::put('/admin/lightsabers/{lightsaber}', [LightsabersController::class, 'update'])->name('sabers.update');

// DELETE
Route::delete('/admin/lightsabers/{lightsaber}', [LightsabersController::class, 'destroy'])->name('sabers.destroy');
*/


```

Before moving forward we need to set the migration and seeder and populate the db with data!

### Define the migration

todo

### Define the seeder

todo

### Seed the db

todo

### implement the resource controller methods

#### Implement the index method to show a list of resources

```php

// this responds to the route with a name lightsabers.index as defined by the resource controller

public function index(){
    // implement the logic

    // take all data for the give model from the db
    $sabers = Lightsaber::all();
    // return the view and pass the data to it.
    return view('admin.lightsabers', compact('sabers')); // <-- pay attention to the convention used by laravel

}

```

#### Implement the create method

Here we return a view with a form

```php

  /**
     * Show the form for creating a new resource.
     */
    public function create() // risponde alla rotta /admin/lightsabers/create (GET)
    {
        return view('admin.lightsabers.create'); // <-- pay attention to the convention used by laravel
    }

```

We can create a form inside the view called admin/lightsabvers/create

```php
@extends('layouts.admin')


@section('content')

<div class="container">

    //👇 The action must point to the store route that will handle the request to save the record in the db
    <form action="{{route('lightsabers.store')}}" method="POST" enctype="multipart/form-data">
        // use the multipart form data to store files           👆
        <!-- 👇 // Attention to Cross site request forgery attacks -->
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            // Add the name attribute to the inputs 👇
            <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Acolyte Eco Battle staff">
            <small id="nameHelper" class="form-text text-muted">Type the name here</small>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" name="price" id="price" aria-describedby="helpId" placeholder="99.99">
            <small id="priceHelper" class="form-text text-muted">Type the price here</small>

        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Choose file</label>
            <input type="file" class="form-control" name="cover_image" id="cover_image" placeholder="" aria-describedby="cover_image_helper">
            <div id="cover_image_helper" class="form-text">Upload an image for the current product</div>
        </div>


        <button type="submit" class="btn btn-primary">
            Save
        </button>


    </form>

</div>


@endsection
```

#### Implement Store method

Save the records in the db using `::create`

```php
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // risponde alla rotta /admin/lightsabers (POST)
    {
        //dd($request->all());

        $data = $request->all();
        //$file_path = null;
        if ($request->has('cover_image')) {
            $file_path =  Storage::put('sabers_images', $request->cover_image);
            $data['cover_image'] = $file_path;
        }
        //dd($file_path);


        # Add a new record the the db

        /* Without mass assignment of fields
        $saber = new LightSaber();
        $saber->name = $request->name;
        $saber->price = $request->price;
        $saber->cover_image = $file_path;
        $saber->save();
        */
        
        # With mass assignment
        //dd($data);
        $lightsaber = LightSaber::create($data);


        // redirectthe user to a get route, follow the pattern ->  POST/REDIRECT/GET
        return to_route('lightsabers.show', $lightsaber); // new function to_route() laravel 9
    }

```

⚡⚡ Attention to the mass assignment error!
When using the create mehtod on the Model instance we must add a fillable property inside the model
For instance:

```php
// Lightsaber model
protected $fillable = ['name', 'cover_image', 'description', 'price'];

```

Add inside the array all fileds used in the create form to save the data.
Without the fillable props you won't be able to save that field in the db.

#### Implement the show method

Inside there are two options, the first is commented out because we are using the DI (dependency injection)
as the controller is paired with the model. When users visit an endopoin that does not exists will return a 404 anyway.

```php
 /**
     * Display the specified resource.
     */
    public function show(LightSaber $lightsaber) // risponde alla rotta /admin/lightsabers/x (GET) Mostra il recond con id x
    {
        //dd($lightsaber);
        /*  $lightSaber = LightSaber::find($id);
        //dd($lightSaber);
        if ($lightSaber) {
            return view('admin.lightsabers.show', compact('lightSaber'));
        }
        abort(404); */
        return view('admin.lightsabers.show', compact('lightsaber'));
    }
```

Now let's work on the view

```php
@extends('layouts.admin')

@section('content')

<div class="p-5 mb-4 bg-dark text-white rounded-0">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">{{$lightsaber->name}}</h1>
        <p>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quos deserunt doloribus laudantium, quidem assumenda maiores labore, quisquam id consequatur ipsam nisi eaque error magni inventore sapiente totam, illo itaque aspernatur?
        </p>
    </div>
</div>

<div class="container d-flex gap-2">

    <img src="{{ asset('storage/' . $lightsaber->cover_image) }}" alt="">
    <div class="text">
        <strong class="text-muted">Description</strong>
        <p class="col-md-8 fs-4">{{$lightsaber->description}}</p>
        <div class="display-3"> ${{$lightsaber->price}}</div>

        <a class="btn btn-success mt-4" href="#" role="button">Buy Now</a>
    </div>


</div>

@endsection

```

#### Implement the edit method

here we show a form pre-populated with data from the given model

```php
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LightSaber $lightsaber)
    {
        return view('admin.lightsabers.edit', compact('lightsaber'));
    }

```

create the form

```php
@extends('layouts.admin')


@section('content')

<div class="container">

    <h1 class="py-4">Edit Saber number: {{$lightsaber->id}}</h1>
    // Remember to update the action route 👇
    <form action="{{route('lightsabers.update', $lightsaber)}}" method="POST" enctype="multipart/form-data">

        <!-- // Attention to Cross site request forgery attacks -->
        @csrf
        // Override the form method 👇
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Acolyte Eco Battle staff" value="{{$lightsaber->name}}">
            // add value= to each input to fill the fields 👆
            <small id="nameHelper" class="form-text text-muted">Type the name here</small>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" name="price" id="price" aria-describedby="helpId" placeholder="99.99" value="{{$lightsaber->price}}">
            // add value= to each input to fill the fields 👆

            <small id="priceHelper" class="form-text text-muted">Type the price here</small>

        </div>

        // In the update form we show the current image to the user
        <div class="d-flex gap-3">
            <div>
                <img width="200" src="{{asset('storage/' . $lightsaber->cover_image)}}" alt="">
            </div>
            <div class="mb-3">
                <label for="cover_image" class="form-label">Update Cover Image</label>
                <input type="file" class="form-control" name="cover_image" id="cover_image" placeholder="" aria-describedby="cover_image_helper">
                <div id="cover_image_helper" class="form-text">Upload an image for the current product</div>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">
            Update
        </button>


    </form>

</div>


@endsection

```

#### Implement the update (U)

Now we need to update the model instance with the new data

```php

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LightSaber $lightsaber)
    {
        //dd($request->all());
        $data = $request->all();
        //dd($lightsaber->cover_image);
        //dd($lightsaber);

        // We need check is the request has the cover_image field 
        // if so delete the image from the filesystem
        if ($request->has('cover_image') && $lightsaber->cover_image) {

            //dd('update the image');
            // delete the previous image
            Storage::delete($lightsaber->cover_image);

            // save the new image and take its path
            $newImageFile = $request->cover_image;
            $path = Storage::put('sabers_images', $newImageFile);
            $data['cover_image'] = $path;
        }

        //dd($data);

        $lightsaber->update($data);
        return to_route('lightsabers.index')->with('message', 'Welldone! Saber updated successfully 👍'); // new function to_route() laravel 9

    }

```

#### Implement the delete method (D)

```php
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LightSaber $lightsaber)
    {
        //dd($lightsaber);
        // Check if the instance has a cover image path and if so delete the image from the filesystem
        if (!is_null($lightsaber->cover_image)) {
            Storage::delete($lightsaber->cover_image);
        }
        // delete the record from the db
        $lightsaber->delete();
        // POST REDIRECT GET
        // redirect with a session message
        return to_route('lightsabers.index')->with('message', 'Welldone! Saber deleted successfully 👍');
    }

```

NOTE Aboute session messages:
To see the session message in the view that the user is redirected to, we need to add the following snippet to the view

```php
@if(session('message'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <strong>Success!</strong> {{session('message')}}
</div>

@endif

```

Read the docs [here](https://laravel.com/docs/10.x/responses#redirecting-with-flashed-session-data)
