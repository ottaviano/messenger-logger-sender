<?php

namespace Ottaviano\Messenger;

use Ottaviano\Messenger\Stamp\LogLevelStamp;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Sender\SenderInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

/**
 * @author Dimitri Gritsajuk <gritsajuk.dimitri@gmail.com>
 */
class LoggerSender implements SenderInterface
{
    private $logger;
    private $serializer;

    public function __construct(LoggerInterface $logger, SerializerInterface $serializer = null)
    {
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    public function send(Envelope $envelope): Envelope
    {
        if (!method_exists($envelope->getMessage(), '__toString')) {
            throw new \InvalidArgumentException('Message must implement __toString method');
        }

        $this->logger->log(
            (string) ($envelope->get(LogLevelStamp::class) ?? LogLevel::INFO),
            $envelope->getMessage(),
            $this->serializer ?
                $this->serializer->encode($envelope) :
                array_merge($envelope->all(), ['message' => $envelope->getMessage()])
        );

        return $envelope;
    }

    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }
}
