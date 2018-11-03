<?php

namespace Tests\Ottaviano\Messenger;

use Ottaviano\Messenger\LoggerSender;
use Ottaviano\Messenger\Stamp\LogLevelStamp;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

/**
 * @author Dimitri Gritsajuk <dimitri.gritsajuk@sensiolabs.com>
 */
class LoggerSenderTest extends TestCase
{
    /** @var LoggerSender */
    private $sender;
    /** @var LoggerInterface|MockObject */
    private $loggerMock;

    protected function setUp()
    {
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->sender = new LoggerSender($this->loggerMock);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSendWithMessageNotStringify()
    {
        $this->sender->send($this->createEnvelope(new \stdClass()));
    }

    public function testSendCallSerializerEncodeMethod()
    {
        $serializerMock = $this->createMock(SerializerInterface::class);

        $serializerMock
            ->expects($this->once())
            ->method('encode')
            ->with($this->isInstanceOf(Envelope::class))
        ;

        $this->sender->setSerializer($serializerMock);

        $this->sender->send($this->createEnvelope(new Message()));
    }

    public function testSendUseEnvelopeLogLevel()
    {
        $envelope = $this->createEnvelope(new Message());
        $envelope = $envelope->with(new LogLevelStamp(LogLevel::DEBUG));

        $this->loggerMock
            ->expects($this->once())
            ->method('log')
            ->with(LogLevel::DEBUG, $envelope->getMessage())
        ;

        $this->sender->send($envelope);
    }

    public function testSendUseDefaultInfoLogLevel()
    {
        $this->loggerMock
            ->expects($this->once())
            ->method('log')
            ->with(LogLevel::INFO, $this->isInstanceOf(Message::class))
        ;

        $this->sender->send($this->createEnvelope(new Message()));
    }

    private function createEnvelope($message): Envelope
    {
        return new Envelope($message);
    }
}

class Message {
    public function __toString(): string
    {
        return 'Hello from test!';
    }
}
