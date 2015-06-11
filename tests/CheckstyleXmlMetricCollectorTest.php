<?php

class CheckstyleXmlMetricCollectorTest extends \PHPUnit_Framework_TestCase
{
    protected $collector;

    public function setUp()
    {
        parent::setUp();

        $this->collector = new CheckstyleXmlMetricCollector(dirname(__FILE__) . '/_files/checkstyle.xml');
    }

    public function testCollectReturnsExpectedMetrics()
    {
        $metrics = $this->collector->collect();

        $this->assertArrayHasKey('error.Generic.WhiteSpace.ScopeIndent.Incorrect', $metrics);
        $this->assertEquals(2, $metrics['error.Generic.WhiteSpace.ScopeIndent.Incorrect']);
        $this->assertArrayHasKey('warning.Generic.Files.LineLength.TooLong', $metrics);
        $this->assertEquals(1, $metrics['warning.Generic.Files.LineLength.TooLong']);
    }
}
