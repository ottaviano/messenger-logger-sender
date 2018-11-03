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
