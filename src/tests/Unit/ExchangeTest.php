<?php

namespace Tests\Unit;

use Hasib\Exchange\Converter;
use PHPUnit\Framework\TestCase;

class ExchangeTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_exchange()
    {
        $res = Converter::currencyConvert('usd', 100);
        $this->assertJson(isset($res['code']),true);
    }
}
