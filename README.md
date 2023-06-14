# Currency Exchanger 

### Usage or Installation 
```
composer create-project hasibul/exchange
```
### Installation 
#### 1. Create our folder for our new package.

Create a fresh Laravel project;

```
composer create-project laravel/laravel example-app
```

After a new Laravel install we got to the inside of the project directory by ` cd example-app `.

#### 2. Install Package using Composer.

Inside your command prompt navigate to the folder with your project name. In our case: `example-app`, and run the following command:

```
composer create-project hasibul/exchange
```

#### 3. Basic Usage.

Let's start by creating a new `ExchangeController` inside of our project Controllers directory, and add the following code:

```
<?php

namespace Hasib\Exchange;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;


class ExchangeController
{
    public function exchange(Request $request){
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
       return Converter::currencyConvert($request->currency, $request->amount, $request->from_currency);
    }
}

```
#### 4. Use Api endpoint. 
Let's see how to work this package in the api endpoint. After run your project your can check your package validity by api endpoint with params like :
#####For default currency:
```
http://127.0.0.1:8000/exchange?currency=usd&amount=1000
```
#####For other currency:
```
http://127.0.0.1:8000/exchange?currency=usd&amount=1000&from_currency=isk
```

