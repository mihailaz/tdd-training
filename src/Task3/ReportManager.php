<?php
/**
 * @license Commerce License Jet Infosystems
 */

namespace App\Task3;

/**
 * Class ReportManager
 *
 * @package App\Task3
 *
 * @author Michael Lazarev
 */
class ReportManager
{
    /** @var ReportGeneratorInterface */
    private $generator;
    /** @var ReportSenderInterface */
    private $sender;
    /** @var UserProviderInterface */
    private $userProvider;

    /**
     * ReportManager constructor.
     *
     * @param ReportGeneratorInterface $generator
     * @param ReportSenderInterface $sender
     * @param UserProviderInterface $userProvider
     */
    public function __construct(ReportGeneratorInterface $generator, ReportSenderInterface $sender, UserProviderInterface $userProvider)
    {
        $this->generator = $generator;
        $this->sender = $sender;
        $this->userProvider = $userProvider;
    }

    /**
     * @return int
     */
    public function processReports(): int
    {
        $reports = $this->generator->generate();

        if (!$reports) {
            $specialReport = $this->generator->generateSpecial();
            $this->sender->send($specialReport, $this->userProvider->getManager());
        }
        $user = $this->userProvider->getUser();
        $auditor = $this->userProvider->getAuditor();
        $even = false;

        foreach ($reports as $report) {
            $this->sender->send($report, $user);

            if ($even) {
                $this->sender->send($report, $auditor);
            }
            $even = !$even;
        }
        $count = count($reports);

        return $count;
    }
}
