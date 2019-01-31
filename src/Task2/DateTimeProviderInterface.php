<?php
/**
 * @license Commerce License Jet Infosystems
 */

namespace App\Task2;

/**
 * Interface DateTimeProviderInterface
 *
 * @package App\Task2
 *
 * @author Michael Lazarev
 */
interface DateTimeProviderInterface
{
    /**
     * @return \DateTime
     */
    public function now(): \DateTime;
}
