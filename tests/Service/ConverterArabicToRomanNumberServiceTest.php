<?php

namespace Katas\Tests\Service;

use Katas\Exception\MaximunArabicNumberValueException;
use Katas\Exception\MinimumArabicNumberValueException;
use Katas\Service\ConverterRomanToArabicNumberService;
use PHPUnit\Framework\TestCase;

class ConverterArabicToRomanNumberServiceTest extends TestCase
{
    /**
     * @Test
     *
     * @dataProvider arabicToRomanUnitsNumbersProvider
     * @dataProvider arabicToRomanTensNumbersProvider
     * @dataProvider arabicToRomanHundredsNumbersProvider
     * @dataProvider arabicToRomanThousandsNumbersProvider
     *
     * @param int    $arabicDoneNumber
     * @param string $romanExpectedNumber
     */
    public function testArabicToRomanConversion(int $arabicDoneNumber, string $romanExpectedNumber): void
    {
        $converter = new ConverterRomanToArabicNumberService();

        $romanNumber = $converter->convert($arabicDoneNumber);

        $this->assertEquals($romanExpectedNumber, $romanNumber);
    }

    /**
     * @Test
     */
    public function testItDoesNotAllowConversionOfNumbersLessThanOne()
    {
        $this->expectException(MinimumArabicNumberValueException::class);

        $converter = new ConverterRomanToArabicNumberService();

        $converter->convert(0);
    }

    /**
     * @Test
     */
    public function testItDoesNotAllowConversionOfNumbersEqualOrGreaterThanFourThousand()
    {
        $this->expectException(MaximunArabicNumberValueException::class);

        $converter = new ConverterRomanToArabicNumberService();

        $converter->convert(4000);
    }


    /**
     * Data providers
     */
    
    /**
     * @return array[]
     */
    public function arabicToRomanUnitsNumbersProvider(): array
    {
        return [
            'Convert number 1' => [1, 'I'],
            'Convert number 2' => [2, 'II'],
            'Convert number 3' => [3, 'III'],
            'Convert number 4' => [4, 'IV'],
            'Convert number 5' => [5, 'V'],
            'Convert number 6' => [6, 'VI'],
            'Convert number 7' => [7, 'VII'],
            'Convert number 8' => [8, 'VIII'],
            'Convert number 9' => [9, 'IX'],
        ];
    }

    /**
     * @return array[]
     */
    public function arabicToRomanTensNumbersProvider(): array
    {
        return [
            'Convert number 10' => [10, 'X'],
            'Convert number 11' => [11, 'XI'],
            'Convert number 12' => [12, 'XII'],
            'Convert number 13' => [13, 'XIII'],
            'Convert number 14' => [14, 'XIV'],
            'Convert number 15' => [15, 'XV'],
            'Convert number 16' => [16, 'XVI'],
            'Convert number 19' => [19, 'XIX'],
            'Convert number 23' => [23, 'XXIII'],
            'Convert number 27' => [27, 'XXVII'],
            'Convert number 30' => [30, 'XXX'],
            'Convert number 33' => [33, 'XXXIII'],
            'Convert number 38' => [38, 'XXXVIII'],
            'Convert number 40' => [40, 'XL'],
            'Convert number 44' => [44, 'XLIV'],
            'Convert number 48' => [48, 'XLVIII'],
            'Convert number 49' => [49, 'XLIX'],
            'Convert number 50' => [50, 'L'],
            'Convert number 53' => [53, 'LIII'],
            'Convert number 60' => [60, 'LX'],
            'Convert number 68' => [68, 'LXVIII'],
            'Convert number 70' => [70, 'LXX'],
            'Convert number 73' => [73, 'LXXIII'],
            'Convert number 79' => [79, 'LXXIX'],
            'Convert number 80' => [80, 'LXXX'],
            'Convert number 84' => [84, 'LXXXIV'],
            'Convert number 88' => [88, 'LXXXVIII'],
            'Convert number 99' => [99, 'XCIX'],
        ];
    }

    /**
     * @return array[]
     */
    public function arabicToRomanHundredsNumbersProvider(): array
    {
        return [
            'Convert number 100' => [100, 'C'],
            'Convert number 104' => [104, 'CIV'],
            'Convert number 249' => [249, 'CCXLIX'],
            'Convert number 399' => [399, 'CCCXCIX'],
            'Convert number 400' => [400, 'CD'],
            'Convert number 900' => [900, 'CM'],
            'Convert number 999' => [999, 'CMXCIX'],
        ];
    }

    /**
     * @return array[]
     */
    public function arabicToRomanThousandsNumbersProvider(): array
    {
        return [
            'Convert number 1759' => [1759, 'MDCCLIX'],
            'Convert number 1999' => [1999, 'MCMXCIX'],
            'Convert number 2020' => [2020, 'MMXX'],
            'Convert number 3888' => [3888, 'MMMDCCCLXXXVIII'],
        ];
    }
}
