<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use MMBuxan\VeriFactu\Helpers\DateTimeHelper;

class DateTimeHelperTest extends TestCase
{
    public function testFormatIso8601WithDateTime(): void
    {
        $date = new DateTime('2024-01-01 12:34:56');
        $result = DateTimeHelper::formatIso8601($date);
        $this->assertStringContainsString('2024-01-01T12:34:56', $result);
    }

    public function testFormatIso8601WithString(): void
    {
        $result = DateTimeHelper::formatIso8601('2024-01-01 12:34:56');
        $this->assertStringContainsString('2024-01-01T12:34:56', $result);
    }

    public function testFormatDate(): void
    {
        $result = DateTimeHelper::formatDate('2024-01-01');
        $this->assertEquals('01-01-2024', $result);
    }

    public function testNowIso8601(): void
    {
        $result = DateTimeHelper::nowIso8601();
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/', $result);
    }
} 