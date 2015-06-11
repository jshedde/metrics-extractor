<?php

class JunitXmlMetricCollector extends AbstractXmlMetricCollector implements MetricCollectorInterface
{

    public function collect()
    {
        $nodes = $this->getNodes('/testsuites/testsuite');
        $metrics = array();
        foreach ($nodes as $node) {
            $attributes = $node->attributes;
            $testSuiteName = $attributes->getNamedItem('name')->value;
            $prefix = $this->prefix . $testSuiteName . '.';
            foreach ($attributes as $attribute) {
                $metrics[$prefix .  $attribute->name] = $attribute->value;
            }
        }

        return $metrics;
    }
}
