<?php
/**
 * @license Commerce License Jet Infosystems
 */

namespace Tests\Unit\Task3;

use App\Task3\Auditor;
use App\Task3\Manager;
use App\Task3\SpecialReport;
use App\Task3\ReportGeneratorInterface;
use App\Task3\Report;
use App\Task3\ReportManager;
use App\Task3\ReportSenderInterface;
use App\Task3\UserInterface;
use App\Task3\UserProviderInterface;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;

/**
 * Class ReportManagerTest
 *
 * @package Tests\Unit\Task3
 *
 * @author Michael Lazarev
 */
class ReportManagerTest extends Unit
{
    /** @var \UnitTester */
    protected $tester;

//    public function testProcessReports_WhenCalled_ReturnsCountOfProcessedReports(): void
//    {
//        $manager = $this->makeEmptyExcept(ReportManager::class, 'processReports');
//
//        $count = $manager->processReports();
//
//        $this->assertEquals(2, $count);
//    }

// откуда берутся отчеты?? вводим понятие генератора отчетов (как он будет реализован не знаем и не интересно,
// поэтому интерфейс), теперь тест неактуален, пишем новый

    /**
     * @throws \Exception
     */
    public function testProcessReports_WhenCalled_ReturnsCountOfGeneratedReports(): void
    {
        $generator = $this->makeEmpty(ReportGeneratorInterface::class, [
            'generate' => [
                $this->makeEmpty(Report::class),
                $this->makeEmpty(Report::class),
            ],
        ]);
        $sender = $this->makeEmpty(ReportSenderInterface::class);
        $userProvider = $this->makeEmpty(UserProviderInterface::class, [
            'getUser' => $this->makeEmpty(UserInterface::class),
        ]);
        $manager = $this->makeReportManagerExcept(
            'processReports',
            compact('generator', 'sender', 'userProvider')
        );

        $count = $manager->processReports();

        $this->assertEquals(2, $count);
    }

    /**
     * @throws \Exception
     */
    public function testProcessReports_SomeReportsAreGenerated_SendAllReports()
    {
        $generate = [$this->makeEmpty(Report::class), $this->makeEmpty(Report::class)];
        $generator = $this->makeEmpty(ReportGeneratorInterface::class, compact('generate'));
        $user = $this->makeEmpty(UserInterface::class);
        $sent = [];
        $sender = $this->makeEmpty(ReportSenderInterface::class, [
            'send' =>
//            можно убрать проверку, что вызван дважды, т.к. assert внизу упадет
//                Expected::exactly(
//                    2,
                    function ($r, $u) use (&$sent, &$user) {
//                 	    $this->assertInstanceOf(Report::class, $r);
                        // нужно проверить, что именно тот отчет
                        $sent[] = $r;
                    }
//                ),
        ]);
        $userProvider = $this->makeEmpty(UserProviderInterface::class, [
            'getUser' => function () use ($user) {
            	return $user;
            },
        ]);
        $manager = $this->makeReportManagerExcept(
            'processReports',
            compact('generator', 'sender', 'userProvider')
        );

        $manager->processReports();

        $this->assertEquals(array_merge($generate, [$generate[1]]), $sent, '', 0.0, 10, true);
    }

    /**
     * @throws \Exception
     */
    public function testProcessReports_WhenCall_GenerateOnce(): void
    {
        $generator = $this->makeEmpty(ReportGeneratorInterface::class, [
            'generate' => Expected::once(function () {
            	return [];
            }),
        ]);
        $sender = $this->makeEmpty(ReportSenderInterface::class);
        $userProvider = $this->makeEmpty(UserProviderInterface::class, [
            'getUser' => $this->makeEmpty(UserInterface::class),
        ]);
        $manager = $this->makeReportManagerExcept(
            'processReports',
            compact('generator', 'sender', 'userProvider')
        );
        $manager->processReports();
    }

// Вводим понятие Пользователя, Менеджера и Юзер Провайдера

    /**
     * @throws \Exception
     */
    public function testProcessReports_NoReports_SendSpecialReportToManager()
    {
        $specialReport = $this->makeEmpty(SpecialReport::class);
        $generator = $this->makeEmpty(ReportGeneratorInterface::class, [
            'generate' => [],
            'generateSpecial' => $specialReport,
        ]);
        $sender = $this->makeEmpty(ReportSenderInterface::class, [
            'send' => Expected::once(function ($r) use ($specialReport) {
            	$this->assertEquals($specialReport, $r);
            }),
        ]);
        $manager = $this->makeEmpty(Manager::class);
        $userProvider = $this->makeEmpty(UserProviderInterface::class, [
            'getUser' => $this->makeEmpty(UserInterface::class),
            'getManager' => $manager,
        ]);
        $reportManager = $this->makeReportManagerExcept(
            'processReports',
            compact('generator', 'sender', 'userProvider')
        );
        $reportManager->processReports();
    }

    /**
     * @throws \Exception
     */
    public function testProcessReports_EvenReport_SendToAuditor()
    {
        $generate = [$this->makeEmpty(Report::class), $this->makeEmpty(Report::class)];
        $generator = $this->makeEmpty(ReportGeneratorInterface::class, compact('generate'));
        $sentAuditor = [];
        $auditor = $this->makeEmpty(Auditor::class);
        $sender = $this->makeEmpty(ReportSenderInterface::class, [
            'send' => function ($r, $u) use ($auditor, &$sentAuditor) {
//              почему-то не хочет так работать, а хотелось бы
//                if ($u === $auditor) {
                if ($u instanceof Auditor) {
                    $sentAuditor[] = $r;
                }
            },
        ]);
        $userProvider = $this->makeEmpty(UserProviderInterface::class, [
            'getUser' => $this->makeEmpty(UserInterface::class),
            'getAuditor' => $auditor,
        ]);
        $reportManager = $this->makeReportManagerExcept(
            'processReports',
            compact('generator', 'sender', 'userProvider')
        );
        $reportManager->processReports();

        $this->assertEquals([$generate[1]], $sentAuditor);
    }

    /**
     * @param string $method
     * @param array $params
     * @return ReportManager
     * @throws \Exception
     */
    private function makeReportManagerExcept(string $method, array $params = []): ReportManager
    {
        /** @var ReportManager $manager */
        $manager = $this->makeEmptyExcept(
            ReportManager::class,
            $method,
            $params
        );

        return $manager;
    }
}
