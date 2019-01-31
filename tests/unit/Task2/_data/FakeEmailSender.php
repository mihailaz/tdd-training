<?php
/**
 * @license Commerce License Jet Infosystems
 */
namespace Tests\Unit\Task2\_data;

use App\Task2\EmailSenderInterface;

/**
 * Class FakeEmailSender
 *
 * @package Tests\Unit\Task2\_data
 *
 * @author Michael Lazarev
 */
class FakeEmailSender implements EmailSenderInterface
{
    /** @var string */
    public $text;
    /** @var \Exception|null */
    private $exception;

    /**
     * FakeEmailSender constructor.
     *
     * @param \Exception|null $exception
     */
    public function __construct(?\Exception $exception = null)
    {
        $this->exception = $exception;
    }

    /**
     * @param string $text
     * @throws \Exception
     */
    public function send(string $text): void
    {
        $this->text = $text;

        if ($this->exception) {
            throw $this->exception;
        }
    }
}
