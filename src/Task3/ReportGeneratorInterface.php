<?php
/**
 * @license Commerce License Jet Infosystems
 */

namespace App\Task3;

/**
 * Interface ReportGeneratorInterface
 *
 * @package App\Task3
 *
 * @author Michael Lazarev
 */
interface ReportGeneratorInterface
{
    /**
     * @return Report[]
     */
    public function generate(): array;

    /**
     * @return SpecialReport
     */
    public function generateSpecial(): SpecialReport;
}
