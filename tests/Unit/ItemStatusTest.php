<?php
namespace Tests\Unit;

use App\Enum\ItemStatus;
use PHPUnit\Framework\TestCase;

class ItemStatusTest extends TestCase
{
    /**
     * @return void
     */
    public function test_enum_contains_expected_values()
    {
        $this->assertEquals('COMPLETED', ItemStatus::COMPLETED->value);
        $this->assertEquals('ONGOING', ItemStatus::ONGOING->value);
    }

    /**
     * @return void
     */
    public function test_enum_has_only_two_cases()
    {
        $this->assertCount(2, ItemStatus::cases());
    }
}
