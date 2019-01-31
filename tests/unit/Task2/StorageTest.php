<?php
/**
 * @license Commerce License Jet Infosystems
 */

namespace Tests\Unit\Task2;

use App\Task2\Exception\EmailSenderException;
use App\Task2\Storage;
use Codeception\Test\Unit;
use Tests\Unit\Task2\_data\FakeDateTimeProvider;
use Tests\Unit\Task2\_data\FakeEmailSender;
use Tests\Unit\Task2\_data\FakeLogger;

/**
 * Class StorageTest
 *
 * @package App\Tests\Unit\Task2
 *
 * @author Michael Lazarev
 */
class StorageTest extends Unit
{
    /** @var \UnitTester */
    protected $tester;

// не используем моки из фреймворка - делаем свои
// stub - объект, который нужен только чтоб не упало, его поведение не интересует в текущем тесте
// mock - объект, в котором реализуем тестовое поведение, чтоб сработал assert
// а оба они fake

    public function testSave_WhenCalled_CallsSend()
    {
        $mockEmailSender = new FakeEmailSender();
        $stubLogger = new FakeLogger();
        $stubDateTimeProvider = new FakeDateTimeProvider();
        $storage = new Storage($mockEmailSender, $stubLogger, $stubDateTimeProvider);
        $storage->save();
        $this->assertEquals('some text', $mockEmailSender->text);
    }

//    public function testSave_WhenThrows_CallsLoggerWrite()
//    {
//        $stubEmailSender = new FakeEmailSender(new EmailSenderException());
//        $mockLogger = new FakeLogger();
//        $storage = new Storage($stubEmailSender, $mockLogger);
//        $storage->save();
//        $this->assertEquals('some error', $mockLogger->text);
//    }

// новое требование: нужно в лог писать текущую дату
// рефакторим предыдущий тест, т.к. переопределено старое требование

    public function testSave_WhenThrows_CallsLoggerWriteWithTodayDate()
    {
        $stubEmailSender = new FakeEmailSender(new EmailSenderException());
        $stubLogger = new FakeLogger();
        $mockDateTimeProvider = new FakeDateTimeProvider(new \DateTime('2018-01-30'));
        $storage = new Storage($stubEmailSender, $stubLogger, $mockDateTimeProvider);
        $storage->save();
        $this->assertEquals('some error: 2018-01-30', $stubLogger->text);
    }
}
