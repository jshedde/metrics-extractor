<?php

class Project
{
    protected $metrics = array();

    protected $name;

    public function __construct($projectName)
    {
        $this->name = $projectName;
    }

    public function addMetric(MetricInterface $metric)
    {
        $this->metrics[] = $metric;
    }

    public function __toString()
    {
        $return = 'Project : ' . $this->name . PHP_EOL;
        foreach ($this->metrics as $metric) {
            $return .= $metric;
        }

        return $return;
    }
}
