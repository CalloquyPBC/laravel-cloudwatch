# AWS CloudWatch Logger for Laravel

Implementation of [maxbanton AWS handler for monolog.](https://github.com/maxbanton/cwh) in [Laravel](https://github.com/laravel/laravel).

## Requirements

- PHP ^7.1.3
- Laravel >=5.7

## Features

- Automatically include incoming request parameters on every log.
- Included a "requestId" on every log to make it easier to search through logs of a request on cloudwatch.

## Installation

Install the latest version with [Composer](https://getcomposer.org/) by running

```bash
$ composer require dneey/laravel-cloudwatch
```

## Basic Usage

Drop this in your application's .env file with the correct AWS credentials.

```php
AWS_KEY=aws-key
AWS_SECRET=aws-secret
```

That's it!

## AWS

For AWS IAM and policy examples, kindly visit [maxbanton AWS handler for monolog.](https://github.com/maxbanton/cwh)
