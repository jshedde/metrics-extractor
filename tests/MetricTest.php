<?php

class MetricTest extends \PHPUnit_Framework_TestCase
{
    protected $metric;

    public function setUp()
    {
        parent::setUp();

        $this->metric = new Metric('a metric', 42);
    }

    public function testGetName()
    {
        $this->assertEquals('a metric', $this->metric->getName());
    }

    public function testGetValue()
    {
        $this->assertEquals(42, $this->metric->getValue());
    }

    public function testToString()
    {
        $this->assertEquals('a metric;42' . PHP_EOL, $this->metric->__toString());
    }
}
