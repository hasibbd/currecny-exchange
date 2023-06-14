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
