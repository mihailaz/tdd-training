<?php
/**
 * @license Commerce License Jet Infosystems
 */

namespace App\Task2;

use App\Task2\Exception\EmailSenderException;

/**
 * Class Storage
 *
 * @package App\Task2
 *
 * @author Michael Lazarev
 */
class Storage
{
    /** @var EmailSenderInterface */
    protected $emailSender;
    /** @var LoggerInterface */
    protected $logger;
    /** @var DateTimeProviderInterface */
    protected $dateTimeProvider;

    /**
     * Storage constructor.
     *
     * @param EmailSenderInterface $emailSender
     * @param LoggerInterface $logger
     * @param DateTimeProviderInterface $dateTimeProvider
     */
    public function __construct(
        EmailSenderInterface $emailSender,
        LoggerInterface $logger,
        DateTimeProviderInterface $dateTimeProvider
    ) {
        $this->emailSender = $emailSender;
        $this->logger = $logger;
        $this->dateTimeProvider = $dateTimeProvider;
    }

    /**
     * @return void
     */
    public function save(): void
    {
        try {
            $this->emailSender->send('some text');
        } catch (EmailSenderException $e) {
            $this->logger->write('some error: ' . $this->dateTimeProvider->now()->format('Y-m-d'));
        }
    }
}
