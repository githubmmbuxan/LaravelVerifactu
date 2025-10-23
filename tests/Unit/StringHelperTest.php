<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use MMBuxan\VeriFactu\Helpers\StringHelper;

class StringHelperTest extends TestCase
{
    public function testSanitizeRemovesWhitespaceAndEscapes(): void
    {
        $input = "  &Hello <World>  ";
        $expected = '&amp;Hello &lt;World>';
        $this->assertEquals($expected, StringHelper::sanitize($input));
    }

    public function testSanitizeNoSpecialChars(): void
    {
        $input = "Test String";
        $this->assertEquals('Test String', StringHelper::sanitize($input));
    }
} 