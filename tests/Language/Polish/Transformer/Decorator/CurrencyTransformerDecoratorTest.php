<?php

namespace Kwn\NumberToWords\Language\Polish\Transformer\Decorator;

use Kwn\NumberToWords\Language\Polish\Transformer\NumberTransformer;
use Kwn\NumberToWords\Model\Currency;
use Kwn\NumberToWords\Model\Number;

class CurrencyTransformerDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorThrowsExceptionWithUnknownCurrency()
    {
        new CurrencyTransformerDecorator(
            new NumberTransformer(),
            new Currency('UNK')
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorThrowsExceptionWithUnknownFormat()
    {
        new CurrencyTransformerDecorator(
            new NumberTransformer(),
            new Currency('PLN'),
            10
        );
    }

    public function testTransformMoneyUnits()
    {
        $transformer = new CurrencyTransformerDecorator(
            new NumberTransformer(),
            new Currency('PLN'),
            CurrencyTransformerDecorator::FORMAT_SUBUNITS_IN_WORDS
        );

        $this->assertEquals('jeden złoty zero groszy', $transformer->toWords(new Number(1)));
        $this->assertEquals('dwa złote zero groszy', $transformer->toWords(new Number(2)));
        $this->assertEquals('pięć złotych zero groszy', $transformer->toWords(new Number(5)));
        $this->assertEquals('pięćset czterdzieści jeden złotych zero groszy', $transformer->toWords(new Number(541)));
        $this->assertEquals('pięćset czterdzieści dwa złote zero groszy', $transformer->toWords(new Number(542)));
        $this->assertEquals('pięćset czterdzieści cztery złote zero groszy', $transformer->toWords(new Number(544)));
        $this->assertEquals('pięćset czterdzieści pięć złotych zero groszy', $transformer->toWords(new Number(545)));
    }

    public function testDefaultSubunitFormatIsWords()
    {
        $transformer = new CurrencyTransformerDecorator(
            new NumberTransformer(),
            new Currency('PLN')
        );

        $this->assertEquals('pięćset czterdzieści trzy złote zero groszy', $transformer->toWords(new Number(543)));
        $this->assertEquals('pięćset czterdzieści dziewięć złotych dwadzieścia groszy', $transformer->toWords(new Number(549.20)));
    }

    public function testTransformMoneySubunitsNumberFormat()
    {
        $transformer = new CurrencyTransformerDecorator(
            new NumberTransformer(),
            new Currency('PLN'),
            CurrencyTransformerDecorator::FORMAT_SUBUNITS_IN_NUMBERS
        );

        $this->assertEquals('pięćset czterdzieści pięć złotych 52/100', $transformer->toWords(new Number(545.52)));
        $this->assertEquals('pięćset czterdzieści pięć złotych 0/100', $transformer->toWords(new Number(545)));
        $this->assertEquals('pięćset czterdzieści pięć złotych 99/100', $transformer->toWords(new Number(545.99)));
    }

    public function testTransformMoneySubunitsWordsFormat()
    {
        $transformer = new CurrencyTransformerDecorator(
            new NumberTransformer(),
            new Currency('PLN'),
            CurrencyTransformerDecorator::FORMAT_SUBUNITS_IN_WORDS
        );

        $this->assertEquals('pięćset czterdzieści pięć złotych pięćdziesiąt dwa grosze', $transformer->toWords(new Number(545.52)));
        $this->assertEquals('pięćset czterdzieści pięć złotych zero groszy', $transformer->toWords(new Number(545)));
        $this->assertEquals('pięćset czterdzieści pięć złotych jeden grosz', $transformer->toWords(new Number(545.01)));
        $this->assertEquals('pięćset czterdzieści pięć złotych dziewięćdziesiąt dziewięć groszy', $transformer->toWords(new Number(545.99)));
    }
}