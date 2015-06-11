<?php

class CloverXmlMetricCollector extends AbstractXmlMetricCollector implements MetricCollectorInterface
{
    public function collect()
    {
        $nodes = $this->getNodes('/coverage/project/metrics');
        $attributes = $nodes->item(0)->attributes;
        $metrics = array();

        foreach ($attributes as $attribute) {
            $metrics[$this->prefix . $attribute->name] = $attribute->value;
        }

        return $metrics;
    }
}
