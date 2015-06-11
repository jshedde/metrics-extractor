<?php

class PhplocXmlMetricCollectorTest extends \PHPUnit_Framework_TestCase
{
    protected $collector;

    public function setUp()
    {
        parent::setUp();

        $this->collector = new PhplocXmlMetricCollector(dirname(__FILE__) . '/_files/phploc.xml');
    }

    public function testCollectReturnsExpectedMetrics()
    {
        $metrics = $this->collector->collect();

        $this->assertArrayHasKey('directories', $metrics);
        $this->assertEquals(443, $metrics['directories']);
        $this->assertArrayHasKey('loc', $metrics);
        $this->assertEquals(163833, $metrics['loc']);
    }
}
