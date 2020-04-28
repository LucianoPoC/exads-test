<?php

declare(strict_types=1);

namespace App\Lottery;

final class IrishLottery
{
    private const FORMAT = '%Y%M%D%H%I%S%F';

    public function nextDraw(\DateTimeImmutable $date = null): \DateTimeImmutable
    {
        $date = $date ?? new \DateTimeImmutable('now');

        $dateWithTime20hours = clone $date;
        $dateWithTime20hours = $dateWithTime20hours->setTime(20, 00);

        $nextWednesday = $date->modify('next Wednesday');
        if ($this->isWednesday($date) && $date->diff($dateWithTime20hours)->invert === 0) {
            $nextWednesday = clone $date;
        }

        $nextSaturday = $date->modify('next Saturday');
        if ($this->isSaturday($date) && $date->diff($dateWithTime20hours)->invert === 0) {
            $nextSaturday = clone $date;
        }

        $nextWednesday = $nextWednesday->setTime(20, 00);
        $nextSaturday = $nextSaturday->setTime(20, 00);

        $diffWednesday = $date->diff($nextWednesday)->format(self::FORMAT);
        $diffSaturday = $date->diff($nextSaturday)->format(self::FORMAT);

        if ($diffWednesday < $diffSaturday) {
            return $nextWednesday;
        }

        return $nextSaturday;
    }

    /**
     * @param \DateTimeImmutable $date
     *
     * @return bool
     */
    private function isWednesday(\DateTimeImmutable $date): bool
    {
        return (int)$date->format('w') === 3;
}

    /**
     * @param \DateTimeImmutable $date
     *
     * @return bool
     */
    private function isSaturday(\DateTimeImmutable $date): bool
    {
        return (int)$date->format('w') === 6;
}
}
