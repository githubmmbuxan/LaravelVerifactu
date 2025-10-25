<?php

declare(strict_types=1);

use MMBuxan\VeriFactu\Helpers\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    public function test_sanitize_removes_whitespace_and_escapes(): void
    {
        $input = '  &Hello <World>  ';
        $expected = '&amp;Hello &lt;World>';
        $this->assertEquals($expected, StringHelper::sanitize($input));
    }

    public function test_sanitize_no_special_chars(): void
    {
        $input = 'Test String';
        $this->assertEquals('Test String', StringHelper::sanitize($input));
    }
}
