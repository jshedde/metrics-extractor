#!/usr/bin/php
<?php

require 'vendor/autoload.php';


use Liuggio\StatsdClient\StatsdClient,
    Liuggio\StatsdClient\Factory\StatsdDataFactory,
    Liuggio\StatsdClient\Sender\SocketSender,
    Liuggio\StatsdClient\Service\StatsdService;

// use Liuggio\StatsdClient\Sender\SysLogSender;

$longopts  = array(
    'statsd-host:',     // Valeur requise
    'logs-directory:',
    'project-prefix:'
);
$options = getopt(null, $longopts);

foreach ($longopts as $opt) {
    $opt = substr($opt, 0, -1);
    if (false === array_key_exists($opt, $options) || null === $options[$opt]  || false === $options[$opt]  || 0 === strlen(trim($options[$opt]))) {
        throw new \RuntimeException(sprintf('"%s" is required.', $opt));
    }
}

$sender = new SocketSender($options['statsd-host'], 8125, 'udp');
            // $sender = new SysLogSender(); // enabling this, the packet will not send over the socket

$client  = new StatsdClient($sender);
$factory = new StatsdDataFactory('\Liuggio\StatsdClient\Entity\StatsdData');
$service = new StatsdService($client, $factory);

$file = 'clover.xml';

$prefix = $options['project-prefix'];
$logsDir = $options['logs-directory'];

$metrics = array();
$collector = new CloverXmlMetricCollector($logsDir . '/clover.xml', $prefix . 'coverage.');
$metrics = array_merge($collector->collect(), $metrics);

$collector = new JunitXmlMetricCollector($logsDir . '/junit.xml', $prefix . 'phpunit.');
$metrics = array_merge($metrics, $collector->collect());

$collector = new CheckstyleXmlMetricCollector($logsDir . '/checkstyle.xml', $prefix . 'checkstyle.');
$metrics = array_merge($metrics, $collector->collect());

$collector = new PhplocXmlMetricCollector($logsDir . '/phploc.xml', $prefix . 'phploc.');
$metrics = array_merge($metrics, $collector->collect());

//var_dump($metrics);
foreach ($metrics as $metric => $value) {
    echo $metric . '|' . $value . PHP_EOL;
    $service->gauge($metric, $value);
}

$service->flush();
