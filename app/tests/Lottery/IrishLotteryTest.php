<?php

declare(strict_types=1);

namespace App\Tests\Lottery;

use App\Lottery\IrishLottery;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class IrishLotteryTest extends TestCase
{
    private IrishLottery $lottery;

    protected function setUp()
    {
        $this->lottery = new IrishLottery();
    }

    public function testNextDrawGivingMondayDateShouldReturnWednesday(): void
    {
        $monday = new DateTimeImmutable('Mon Apr 27 15:30:51');
        $nextDraw = $this->lottery->nextDraw($monday);
        $this->assertEquals(new DateTimeImmutable('Wed Apr 29 20:00:00'), $nextDraw);
    }

    public function testNextDrawGivingFridayDateShouldReturnWednesdayOrSaturday(): void
    {
        $friday = new DateTimeImmutable('Fri May 01 10:30:00');
        $nextDraw = $this->lottery->nextDraw($friday);
        $this->assertGreaterThanOrEqual($friday, $nextDraw);
        $this->assertEquals('02/05/2020', $nextDraw->format('d/m/yy'));
    }

    public function testNextDrawGivingSaturdayWithTimeLessThan20ShouldReturnSaturday(): void
    {
        $saturday = new DateTimeImmutable('Sat May 02 19:00:00');
        $nextDraw = $this->lottery->nextDraw($saturday);
        $this->assertEquals('02/05/2020', $nextDraw->format('d/m/yy'));
    }

    public function testNextDrawGivingSaturdayWithTimeGraterThan20ShouldReturnWednesday(): void
    {
        $saturday = new DateTimeImmutable('Sat May 02 20:00:01');
        $nextDraw = $this->lottery->nextDraw($saturday);
        $this->assertEquals('06/05/2020', $nextDraw->format('d/m/yy'));
    }
}
