<?php

namespace CalloquyPBC\CloudWatch;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Monolog\Formatter\JsonFormatter;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\WebProcessor;
use PhpNexus\Cwh\Handler\CloudWatch;

class CloudWatchLoggerFactory
{
    /**
     * Custom Monolog instance.
     *
     * @param array $config
     * @return \Monolog\Logger
     *
     * @throws \Exception
     */
    public function __invoke(array $config): Logger
    {
        $requestId = uniqid('', true) . rand(1000, 9999);
        $client = new CloudWatchLogsClient($config["sdk"]);
        $handler = new CloudWatch(
            $client,
            $config['group_name'],
            $config['stream_name'],
            $config["retention"],
            $config["batch"],
            $config["tags"] ?? []
        );
        $handler->setFormatter(new JsonFormatter());
        $handler->pushProcessor(new IntrospectionProcessor($config['level'], ["Illuminate\\"]));
        $handler->pushProcessor(new WebProcessor());
        $handler->pushProcessor(function ($entry) use ($config, $requestId) {
            $entry['extra']['requestId'] = $requestId;
            $entry['extra']['requestBody'] = $config['log_requests']
                ? app('Illuminate\Http\Request')->except($config['log_requests_except'])
                : [];
            return $entry;
        });
        $logger = new Logger($config["name"]);
        $logger->pushHandler($handler);

        return $logger;
    }
}
