<?php
/**
 * @license Commerce License Jet Infosystems
 */

namespace App\Task3;

/**
 * Interface UserProviderInterface
 *
 * @package App\Task3
 *
 * @author Michael Lazarev
 */
interface UserProviderInterface
{
    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface;

    /**
     * @return Manager
     */
    public function getManager(): Manager;

    /**
     * @return Auditor
     */
    public function getAuditor(): Auditor;
}
