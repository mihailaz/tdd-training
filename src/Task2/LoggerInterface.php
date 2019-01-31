<?php
/**
 * @license Commerce License Jet Infosystems
 */

namespace App\Task2;

/**
 * Interface LoggerInterface
 *
 * @package App\Task2
 *
 * @author Michael Lazarev
 */
interface LoggerInterface
{
    /**
     * @param string $text
     * @return void
     */
    public function write(string $text): void;
}
