#!/usr/bin/php
<?php

require 'vendor/autoload.php';

$file = 'clover.xml';

$collector = new CloverXmlMetricCollector($file, 'phpunit.coverage.');
var_dump($collector->collect());
#$nodes = $node->childNodes;







exit;

$projectName = 'portal';
#$projectName = 'core';
$project = new Project($projectName);

foreach (array('checkstyle', 'pmd', 'dry') as $metricType) {
    $data = json_decode(file_get_contents('http://ci.lafourchette.lan:8080/view/B2C/job/lafourchette-' . $projectName . '-master-nightly/lastBuild/' . $metricType . 'Result/api/json'), true);
    $project->addMetric(new Metric($metricType . ' / numberOfHighPriorityWarnings', $data['numberOfHighPriorityWarnings']));
    $project->addMetric(new Metric($metricType . ' / numberOfNormalPriorityWarnings', $data['numberOfNormalPriorityWarnings']));
    $project->addMetric(new Metric($metricType . ' / numberOfLowPriorityWarnings', $data['numberOfLowPriorityWarnings']));
}
$data = json_decode(file_get_contents('http://ci.lafourchette.lan:8080/view/B2C/job/lafourchette-' . $projectName . '-master-nightly/lastBuild/testReport/api/json'), true);
$project->addMetric(new Metric('phpunit / pass', $data['passCount']));
$project->addMetric(new Metric('phpunit / fail', $data['failCount']));
$data = file_get_contents('http://ci.lafourchette.lan:8080/view/B2C/job/lafourchette-' . $projectName . '-master-nightly/lastBuild/cloverphp-report/');
//$x('//table[@class="coverage"]/tbody/tr/td[@class="data"]')
$document = new DOMDocument();
$document->loadHTML($data);
$xpath = new DOMXpath($document);
$nodes = $xpath->query('//table[@class="coverage"]');
$node = $nodes->item(0)->childNodes->item(1);
$nodes = $node->childNodes;
$project->addMetric(new Metric('coverage / method', strtr($nodes->item(4)->textContent, array(PHP_EOL => '', '                ' => ' '))));
$project->addMetric(new Metric('coverage / statement', strtr($nodes->item(5)->textContent, array(PHP_EOL => '', '                ' => ' '))));
echo $project;
