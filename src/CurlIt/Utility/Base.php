<?php

namespace CurlIt\Utility;

/**
 * Class used for converting between bases
 * and custom bases using digit libraries.
 */
class Base
{
    /**
     * The library to use.
     * 
     * @var array
     */
    private $library = [];

    /**
     * The base to convert to.
     * 
     * @var int
     */
    private $base;
    
    /**
     * Construct the new BaseConverter.
     * 
     * If base is 36 or below, the library
     * for this base will be automatically
     * loaded using [0-9][A-Z]. Otherwise,
     * you need to load your own library
     * using the setLibrary and putLibrary
     * member functions.
     * 
     * @param int $base The base to convert to.
     */
    public function __construct(int $base)
    {
        $this->base = $base;
        if ($base <= 36) {
            $this->setLibraryToBase36($base);
        }
    }

    /**
     * Set the library to a specific library.
     * This will override all existing libraries.
     * 
     * @param array $library The new library.
     */
    public function setLibrary(array $library)
    {
        $this->library = [-1 => $library];
    }

    /**
     * Add a new library.
     * 
     * @param array $library   The new library.
     * @param int   $placement The placement to use for this library. 
     *                         For Base-10: 0 = 1s place, 1 = 10s place, ...
     */
    public function putLibrary(array $library, int $placement = -1)
    {   
        if (count($library) != $this->base) {
            throw new \Exception(
                'BaseConverter: Invalid library size. Not equal to base.'
            );
        }
        $this->library[$placement] = $library;
        return true;
    }

    /**
     * Set the library to base-36 [0-9][a-z].
     */
    private function setLibraryToBase36()
    {
        $this->setLibrary(
            array_merge(
                explode(' ', '0 1 2 3 4 5 6 7 8 9'),
                range('a', 'z')
            )
        );
    }

    /**
     * Convert a number to the base that this class uses.
     * 
     * @param int $input     The number to convert.
     * @param int $maxDigits The maximum number of digits the
     *                       resulting number may have.
     * 
     * @return string The number converted to this base.
     */
    public function parse(int $input, int $maxDigits = -1)
    {
        if (! array_key_exists(-1, $this->library)) {
            throw new \Exception('Base: Missing default library.');
        }
        // Compile the indexs to retrieve from the library
        // based on the information provided.
        $compiled = $this->makeIndexes($input, $maxDigits);
        // Retrieve the corresponding entries from
        // the library to build the resulting string.
        //
        // Make sure each words has it's first letter
        // set to Upper Case so that digits are 
        // distinct from one another.
        $result = [];
        foreach ($compiled as $placement => $compiledDigit) {
            $result[] = ucfirst(
                (
                    array_key_exists($placement, $this->library)
                        ? $this->library[$placement][$compiledDigit] 
                        : $this->library[-1        ][$compiledDigit]
                )
            );
        }
        // Return the result.
        return implode('', array_reverse($result));
    }

    /**
     * Converts a value using this base back to base-10.
     * 
     * @param string $value The value to convert to base-10.
     * 
     * @return number The resulting base-10 number.
     */
    public function toBase10(string $value)
    {
        $pieces = preg_split('/(?=[A-Z0-9])/', $value);
        $pieces = array_slice($pieces, 1, count($pieces) - 1);
        $pieces = array_reverse($pieces);
        $compiled = [];

        foreach ($pieces as $placement => $digit) {
            $digit = strtolower($digit);
            $compiled[] = (
                array_key_exists($placement, $this->library)
                    ? array_search($digit, $this->library[$placement], true)
                    : array_search($digit, $this->library[-1        ], true)
            );
        }

        $result = 0;
        foreach ($compiled as $placement => $index)
        {
            $result += ($index*pow($this->base, $placement));
        }
        return $result;
    }

    /**
     * Generate the indexes for a converted number based on this base.
     * 
     * @param int $input     The number to convert.
     * @param int $maxDigits The maximum number of digits the
     *                       resulting number may have.
     * 
     * @return array The resulting indexes as an array in reverse order.
     */
    private function makeIndexes(int $input, int $maxDigits = -1)
    {
        // Make sure our input isn't larger than the maxium
        // number allowed based on maxDigits and base.
        if ($input > pow($this->base, $maxDigits) && $maxDigits != -1) {
            throw new \Exception(
                'Base: Input is larger than maximum supported '.
                'number based on library size and maximum digits.'
            );
        }
        // Generate our compiled list of digits.
        $compiled = [];
        do {
            $d = (int)($input / $this->base);
            $r = $input % $this->base;
            $compiled[] = $r;
            $input = $d;
        } while ($input >= $this->base);
        if ($input > 0) {
            $compiled[] = $input;
        }
        
        return $compiled;
    }

    /**
     * Convert a string conforming to the format of this
     * base to another base.
     * 
     * @param string   $val  The value to convert.
     * @param self|int $base The base to convert to.
     * 
     * @return string The value.
     */
    public function convert(string $val, $base)
    {
        if (! ($base instanceof self)) {
            if (! is_int($base) || $base < 2 || $base > 36) {
                throw new \Exception(
                    'Base: Inavlid base to convert to. '.
                    'Must be within range of 2 - 36 (inclusive).'
                );
            }
            $base = new self($base);
        }
        return $base->parse(
            $this->toBase10($val)
        );
    }
}