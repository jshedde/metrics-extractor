<?php

class JunitXmlMetricCollectorTest extends \PHPUnit_Framework_TestCase
{
    protected $collector;

    public function setUp()
    {
        parent::setUp();

        $this->collector = new JunitXmlMetricCollector(dirname(__FILE__) . '/_files/junit.xml');
    }

    public function testCollectReturnsExpectedMetrics()
    {
        $metrics = $this->collector->collect();

        $this->assertArrayHasKey('src.tests', $metrics);
        $this->assertEquals(905, $metrics['src.tests']);
        $this->assertArrayHasKey('src.assertions', $metrics);
        $this->assertEquals(4804, $metrics['src.assertions']);
        $this->assertArrayHasKey('src.failures', $metrics);
        $this->assertEquals(0, $metrics['src.failures']);
        $this->assertArrayHasKey('src.errors', $metrics);
        $this->assertEquals(0, $metrics['src.errors']);
        $this->assertArrayHasKey('src.time', $metrics);
        $this->assertEquals(1291.875759, $metrics['src.time']);
    }
}
