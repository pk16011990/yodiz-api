<?php
declare(strict_types=1);

namespace App\Model\Yodiz\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DateTimeFormatterTwigExtension extends AbstractExtension
{
    private const DATETIME_UNITS_SECONDS = [
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    ];

    public function getFilters(): array
    {
        return [
            new TwigFilter('ago', [$this, 'ago']),
            new TwigFilter('hoursAndMinutes', [$this, 'hoursAndMinutes']),
        ];
    }

    public function ago(\DateTimeInterface $dateTime): string
    {
        $secondsAgo = time() - $dateTime->getTimestamp();

        foreach (self::DATETIME_UNITS_SECONDS as $unitSeconds => $unit) {
            if ($secondsAgo >= $unitSeconds) {
                $numberOfUnits = floor($secondsAgo / $unitSeconds);

                if ($unit === 'second' ) {
                    return 'a few seconds ago';
                }

                if ($numberOfUnits > 1) {
                    return sprintf('%d %ss ago', $numberOfUnits, $unit);
                }

                return sprintf('a %s ago', $unit);
            }
        }

        if ($secondsAgo === 0) {
            return 'now';
        }

        return 'in future';
    }

    public function hoursAndMinutes(float $hours): string
    {
        return sprintf('%d:%\'.02d', (int)$hours, (int)(60 * ($hours - (int)$hours)));
    }

}