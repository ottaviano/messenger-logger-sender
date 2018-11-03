# LoggerSender for Symfony Messenger

[![Build Status](https://travis-ci.org/ottaviano/messenger-logger-sender.svg?branch=master)](https://travis-ci.org/ottaviano/messenger-logger-sender)

[Symfony Messenger](https://github.com/symfony/messenger) :heart:

LoggerSender requires a `Psr\LoggerInterface` object, and can be used with [`monolog/monolog`](https://packagist.org/packages/monolog/monolog) lib for example which 
provides a lot of handlers like `StreamHandler`, `RavenHandler`, `SlackHandler`, [etc](https://github.com/Seldaek/monolog/tree/master/src/Monolog/Handler).

## Installation

```bash
composer require ottaviano/messenger-logger-sender
```

## Beta

This lib is in Beta version as the component Messenger is in Beta too.

## Example

### Monolog & StreamHandler

```php
$loggerSender = new \Ottaviano\Messenger\LoggerSender(
    new \Monolog\Logger(
        'default', 
        [
            new \Monolog\Handler\StreamHandler(STDOUT),
        ]
    )
);

$middlewares = [
    new \Symfony\Component\Messenger\Middleware\SendMessageMiddleware(
        new \Symfony\Component\Messenger\Transport\Sender\SendersLocator([
            '*' => [$loggerSender],
        ])
    ),
];

$bus = new \Symfony\Component\Messenger\MessageBus($middlewares);

$message = new class {
    function __toString() {
        return 'Hey!';
    }
};

$bus->dispatch($message);
```
it will output:
```
[2018-11-03 18:26:26] default.INFO: Hey! {"message":"[object] (class@anonymous\u0000/Users/dimitri/Projects/test-messenger/script4.php0x101422223: Hey!)"} []
```
