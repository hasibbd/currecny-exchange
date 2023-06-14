# Laravel Currency Exchanger 

### Usage or Installation 
```
composer require mamunur6286/currex
```

# How to Use Currex
As a developer we need different types of currency exchange for our various projects. For this situation I developed a laravel package to prevent this problem to handle currency change. It can improve your development life if you use it properly. The used precondition and instruction is given below!

In this tutorial, I'll take you through an example on how to use the Currex Laravel package in just 5 steps. So, let's go ahead and dive into it.

#### 1. Create our folder for our new package.

Create a fresh Laravel project;

```
composer create-project laravel/laravel example-app
```

After a new Laravel install we got to the inside of the project directory by ` cd example-app `.

#### 2. Install Currex Package using Composer.

Inside your command prompt navigate to the folder with your project name. In our case: `example-app`, and run the following command:

```
composer require mamunur6286/currex
```

This will initialize the `Currex` package in your project and update the composer dependencies in `composer.json` file.

Next, we need to add our new Service Provider in our config/app.php inside of the `providers[]` array:

```
'providers' => [

    /*
     * Laravel Framework Service Providers...
     */
    Illuminate\Auth\AuthServiceProvider::class,
    //.. Other providers
    
    Mamunur6286\Currex\Providers\CurrenryServiceProvider::class,

],
```

Awesome! Our service provider is loaded and our package is ready to go! But we don't have any functionality yet... Let's tackle that by adding a Controller for our Project.

#### 5. Basic Usease

Let's start by creating a new `ConvertController` inside of our project Controllers directory, and add the following code:

```
<?php
use Mamunur6286\Currex\Convert;

class ConvertController
{
    private $convert;
    // set convert instance in convert property
    public function __construct(Convert $convert) {
	$this->convert = $convert;
    }
}

```
Then let's create an exchange method inside your controller `exchange()` and flow bellow code:

```
    public function exchange(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'currency' => 'required',
                'amount' => 'required',
            ]);
        
            if ($validator->fails()) {
                return ([
                    'success' => false,
                    'errors' => $validator->errors()
                ]);
            }

            return  $this->convert->exchangeTo($request);

        } catch (\Exception $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
```

#### 7. Use Api endpoint. 
Let's see how to work this package in the api endpoint. After run your project your can check your package validity by api endpoint with params like :

```
http://localhost:8000/exchange?currency=USD&amount=100
```


#### Conclusion. 
That's how to use the Laravel Currency Exchanger package. Thank you for using Currex. 
