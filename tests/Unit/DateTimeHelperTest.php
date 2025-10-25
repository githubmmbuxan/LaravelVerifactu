<?php

declare(strict_types=1);

use MMBuxan\VeriFactu\Helpers\DateTimeHelper;
use PHPUnit\Framework\TestCase;

class DateTimeHelperTest extends TestCase
{
    public function test_format_iso8601_with_date_time(): void
    {
        $date = new DateTime('2024-01-01 12:34:56');
        $result = DateTimeHelper::formatIso8601($date);
        $this->assertStringContainsString('2024-01-01T12:34:56', $result);
    }

    public function test_format_iso8601_with_string(): void
    {
        $result = DateTimeHelper::formatIso8601('2024-01-01 12:34:56');
        $this->assertStringContainsString('2024-01-01T12:34:56', $result);
    }

    public function test_format_date(): void
    {
        $result = DateTimeHelper::formatDate('2024-01-01');
        $this->assertEquals('01-01-2024', $result);
    }

    public function test_now_iso8601(): void
    {
        $result = DateTimeHelper::nowIso8601();
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/', $result);
    }
}
