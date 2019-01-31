<?php
/**
 * @license Commerce License Jet Infosystems
 */

namespace App\Task2;

use App\Task2\Exception\EmailSenderException;

/**
 * Interface EmailSenderInterface
 *
 * @package App\Task2
 *
 * @author Michael Lazarev
 */
interface EmailSenderInterface
{
    /**
     * @return void
     * @throws EmailSenderException
     */
    public function send(string $text): void;
}
