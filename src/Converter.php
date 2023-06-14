<?php

namespace Hasib\Exchange;

use PHPUnit\Exception;

class Converter
{
    public static function currencyConvert($target_currency, $amount, $from_currency = 'eur')
    {
        $url = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";
        $response = [];
        try {
            $xmlString = file_get_contents($url);
            $xml = simplexml_load_string($xmlString);
            $json = json_encode($xml);
            $array = json_decode($json, true);
            $datas = isset($array['Cube']['Cube']['Cube']) ? $array['Cube']['Cube']['Cube'] : null;
            if ($datas){
                $check = self::converter($datas, $target_currency, $amount, $from_currency);
                if ($check){
                    $response = [
                        'amount' => $amount,
                        'converted_amount' => $check,
                        'to' => $target_currency,
                        'from' => $from_currency ? $from_currency : 'EUR',
                        'code' => 1000,
                        'message' => 'Success'
                    ];
                }
                else {
                    $response = [
                        'amount' => $amount,
                        'converted_amount' => null,
                        'to' => $target_currency,
                        'from' => $from_currency ? $from_currency : 'ERU',
                        'code' => 1002,
                        'message' => 'Failed to convert'
                    ];
                }
            } else {
                $response = [
                    'amount' => $amount,
                    'converted_amount' => null,
                    'to' => $target_currency,
                    'from' => $from_currency ? $from_currency : 'ERU',
                    'code' => 1002,
                    'message' => 'Failed to fetch'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'amount' => $amount,
                'converted_amount' => null,
                'to' => $target_currency,
                'from' => $from_currency ? $from_currency : 'ERU',
                'code' => 1001,
                'message' => 'Failed to retrieve'
            ];
        }
        return response()->json($response);
    }

    public static function converter(array $array, $to, $amount = 0, $from = null)
    {
        $total = 0;
        if ($from != null) {
            $f_rate = self::searchObjectByProperty($array, 'currency', $to);
            if ($f_rate) {
                $target_total = $amount * $f_rate['amount'];
                $rate = self::searchObjectByProperty($array, 'currency', $from);
                if ($rate) {
                    $total = $target_total / $rate['amount'];
                } else {
                    $total = null;
                }
            } else {
                $total = null;
            }
        } else {
            $rate = self::searchObjectByProperty($array, 'currency', strtoupper($to));
            if ($rate) {
                $total = $amount * $rate['amount'];
            } else {
                $total = null;
            }
        }
        return $total ? round($total, 4) : null;
    }

    public static function searchObjectByProperty(array $array, $propertyName, $targetValue)
    {
        foreach ($array as $object) {
            if (isset($object['@attributes'][$propertyName])) {
                if ($object['@attributes'][$propertyName] === strtoupper($targetValue)) {
                    return [
                        'amount' => $object['@attributes']['rate'],
                        'success' => true
                    ]; // Return the matching object
                }
                if (strtoupper($targetValue) == 'EUR') {
                    return [
                        'amount' => 1,
                        'success' => true
                    ];
                }
            }
        }
        return null;
    }

}
