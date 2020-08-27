<?php


namespace Katas;

class ConverterRomanToArabicNumber
{
    const ROMAN_NUMBER_ONE = 'I';
    const ROMAN_NUMBER_FIVE = 'V';
    const ROMAN_NUMBER_TEN = 'X';
    const ROMAN_NUMBER_FIFTY = 'L';
    const ROMAN_NUMBER_HUNDRED = 'C';
    const ROMAN_NUMBER_FIVE_HUNDRED = 'D';
    const ROMAN_NUMBER_THOUSAND = 'M';

    const ARABIC_TO_ROMAN_NUMBERS_EQUIVALENCE = [
        1    => self::ROMAN_NUMBER_ONE,
        5    => self::ROMAN_NUMBER_FIVE,
        10   => self::ROMAN_NUMBER_TEN,
        50   => self::ROMAN_NUMBER_FIFTY,
        100  => self::ROMAN_NUMBER_HUNDRED,
        500  => self::ROMAN_NUMBER_FIVE_HUNDRED,
        1000 => self::ROMAN_NUMBER_THOUSAND,
    ];

    /**
     * @param int $arabicNumber
     *
     * @return string|null
     */
    public function convert(int $arabicNumber): ?string
    {
        $romanNumber                     = null;
        $arabicNumberDecreasingCounter   = $arabicNumber;
        $arabicToRomanNumbersEquivalence = $this->getDecreasingOrderedArabicToRomanNumbersEquivalence();

        array_walk(
            $arabicToRomanNumbersEquivalence,
            function ($roman, $arabic) use (&$romanNumber, &$arabicNumberDecreasingCounter) {
                while ($arabicNumberDecreasingCounter >= $arabic) {
                    $initialRomanNumberRepetitions = $arabicNumberDecreasingCounter / $arabic;

                    if (substr((string)$arabic, 0, 1) === '1' && $initialRomanNumberRepetitions >= 4) {
                        $nextBaseFiveArabicToRomanNumberEquivalence = $this->getNextArabicToRomanNumbersEquivalence($arabic);
                        if (! empty($nextBaseFiveArabicToRomanNumberEquivalence)) {
                            $nextArabic = key($nextBaseFiveArabicToRomanNumberEquivalence);
                            $nextRoman  = $nextBaseFiveArabicToRomanNumberEquivalence[$nextArabic];

                            $romanNumber                   .= $roman.$nextRoman;
                            $arabicNumberDecreasingCounter -= $arabic * 4;
                            continue;
                        }
                    }

                    if (substr((string)$arabic, 0, 1) === '5' && $initialRomanNumberRepetitions > 1) {
                        $previousBaseFiveArabicToRomanNumberEquivalence = $this->getPreviousArabicToRomanNumbersEquivalence($arabic);
                        $previousArabic                                 = key($previousBaseFiveArabicToRomanNumberEquivalence);
                        $previousRoman                                  = $previousBaseFiveArabicToRomanNumberEquivalence[$previousArabic];

                        $nextBaseFiveArabicToRomanNumberEquivalence = $this->getNextArabicToRomanNumbersEquivalence($arabic);
                        $nextArabic                                 = key($nextBaseFiveArabicToRomanNumberEquivalence);
                        $nextRoman                                  = $nextBaseFiveArabicToRomanNumberEquivalence[$nextArabic];

                        if ($arabicNumberDecreasingCounter >= ($nextArabic - $previousArabic) && $arabicNumberDecreasingCounter < $nextArabic) {
                            $romanNumber                   .= $previousRoman.$nextRoman;
                            $arabicNumberDecreasingCounter -= $nextArabic - $previousArabic;
                            continue;
                        }
                    }

                    $romanNumber                   .= $roman;
                    $arabicNumberDecreasingCounter -= $arabic;
                }
            }
        );

        return $romanNumber;
    }

    /**
     * Private functions
     */

    /**
     * @return string[]
     */
    private function getDecreasingOrderedArabicToRomanNumbersEquivalence(): array
    {
        $arabicToRomanNumbersEquivalences = self::ARABIC_TO_ROMAN_NUMBERS_EQUIVALENCE;

        uksort($arabicToRomanNumbersEquivalences, function ($a, $b) {
            return $b <=> $a;
        });

        return $arabicToRomanNumbersEquivalences;
    }

    /**
     * @param int $arabicToRomanEquivalenceKey
     *
     * @return array|null
     */
    private function getNextArabicToRomanNumbersEquivalence(int $arabicToRomanEquivalenceKey): ?array
    {
        $arabicToRomanNumbersEquivalences = self::ARABIC_TO_ROMAN_NUMBERS_EQUIVALENCE;

        $keyPosition = array_search($arabicToRomanEquivalenceKey, array_keys($arabicToRomanNumbersEquivalences));

        return array_slice($arabicToRomanNumbersEquivalences, $keyPosition + 1, 1, true);
    }

    /**
     * @param int $arabicToRomanEquivalenceKey
     *
     * @return array|null
     */
    private function getPreviousArabicToRomanNumbersEquivalence(int $arabicToRomanEquivalenceKey): ?array
    {
        $arabicToRomanNumbersEquivalences = self::ARABIC_TO_ROMAN_NUMBERS_EQUIVALENCE;

        $keyPosition = array_search($arabicToRomanEquivalenceKey, array_keys($arabicToRomanNumbersEquivalences));

        return array_slice($arabicToRomanNumbersEquivalences, $keyPosition - 1, 1, true);
    }
}
