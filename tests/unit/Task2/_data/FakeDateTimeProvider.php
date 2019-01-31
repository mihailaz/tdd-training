<?php
/**
 * @license Commerce License Jet Infosystems
 */

namespace Tests\Unit\Task2\_data;

use App\Task2\DateTimeProviderInterface;

/**
 * Class FakeDateTimeProvider
 *
 * @package Tests\Unit\Task2\_data
 *
 * @author Michael Lazarev
 */
class FakeDateTimeProvider implements DateTimeProviderInterface
{
    /** @var \DateTime|null */
    private $now;

    /**
     * FakeDateTimeProvider constructor.
     *
     * @param \DateTime|null $now
     */
    public function __construct(?\DateTime $now = null)
    {
        $this->now = $now;
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function now(): \DateTime
    {
        return $this->now ?: new \DateTime();
    }
}
