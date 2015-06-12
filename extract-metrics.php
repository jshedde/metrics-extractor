#!/usr/bin/php
<?php

require 'vendor/autoload.php';


use Liuggio\StatsdClient\StatsdClient,
    Liuggio\StatsdClient\Factory\StatsdDataFactory,
    Liuggio\StatsdClient\Sender\SocketSender,
    Liuggio\StatsdClient\Service\StatsdService;
            // use Liuggio\StatsdClient\Sender\SysLogSender;

$sender = new SocketSender('delta1.lafourchette.lan', 8125, 'udp');
            // $sender = new SysLogSender(); // enabling this, the packet will not send over the socket

$client  = new StatsdClient($sender);
$factory = new StatsdDataFactory('\Liuggio\StatsdClient\Entity\StatsdData');
$service = new StatsdService($client, $factory);

$file = 'clover.xml';

$prefix = 'lafourchette.ci.b2c.core.';

$metrics = array();
$collector = new CloverXmlMetricCollector('clover.xml', $prefix . 'coverage.');
$metrics = array_merge($collector->collect(), $metrics);

$collector = new JunitXmlMetricCollector('junit.xml', $prefix . 'phpunit.');
$metrics = array_merge($metrics, $collector->collect());

$collector = new CheckstyleXmlMetricCollector('checkstyle.xml', $prefix . 'checkstyle.');
$metrics = array_merge($metrics, $collector->collect());

$collector = new PhplocXmlMetricCollector('phploc.xml', $prefix . 'phploc.');
$metrics = array_merge($metrics, $collector->collect());

//var_dump($metrics);
foreach ($metrics as $metric => $value) {
    $service->gauge($metric, $value);
}

$service->flush();
