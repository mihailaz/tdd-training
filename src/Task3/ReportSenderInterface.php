<?php
/**
 * @license Commerce License Jet Infosystems
 */

namespace App\Task3;

/**
 * Interface ReportSenderInterface
 *
 * @package App\Task3
 *
 * @author Michael Lazarev
 */
interface ReportSenderInterface
{
    /**
     * @param Report $report
     * @param UserInterface $user
     */
    public function send(Report $report, UserInterface $user): void;
}
