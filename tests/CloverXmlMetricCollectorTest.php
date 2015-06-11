<?php

class CloverXmlMetricCollectorTest extends \PHPUnit_Framework_TestCase
{
    protected $collector;

    public function setUp()
    {
        parent::setUp();

        $this->collector = new CloverXmlMetricCollector(dirname(__FILE__) . '/_files/clover.xml');
    }

    public function testCollectReturnsExpectedMetrics()
    {
        $metrics = $this->collector->collect();

        $this->assertArrayHasKey('coveredmethods', $metrics);
        $this->assertEquals(1846, $metrics['coveredmethods']);
        $this->assertArrayHasKey('coveredstatements', $metrics);
        $this->assertEquals(8975, $metrics['coveredstatements']);
    }
}
