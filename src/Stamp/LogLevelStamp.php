<?php

namespace Ottaviano\Messenger\Stamp;

use Psr\Log\LogLevel;
use Symfony\Component\Messenger\Stamp\StampInterface;

/**
 * @author Dimitri Gritsajuk <dimitri.gritsajuk@sensiolabs.com>
 */
class LogLevelStamp implements StampInterface
{
    private $level;

    public function __construct(string $level)
    {
        if (!\defined(sprintf('%s::%s', LogLevel::class, strtoupper($level)))) {
            throw new \InvalidArgumentException(sprintf('"%s" is invalid LogLevel value', $level));
        }

        $this->level = $level;
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    public function __toString(): string
    {
        return $this->level;
    }
}
