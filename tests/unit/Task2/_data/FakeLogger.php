<?php
/**
 * @license Commerce License Jet Infosystems
 */

namespace Tests\Unit\Task2\_data;

use App\Task2\LoggerInterface;

/**
 * Class FakeLogger
 *
 * @package Tests\Unit\Task2\_data
 *
 * @author Michael Lazarev
 */
class FakeLogger implements LoggerInterface
{
    /** @var string */
    public $text;

    public function write(string $text): void
    {
        $this->text = $text;
    }
}
