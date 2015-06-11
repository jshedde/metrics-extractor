<?php

class PhplocXmlMetricCollector extends AbstractXmlMetricCollector implements MetricCollectorInterface
{

    public function collect()
    {
        $nodes = $this->getNodes('/phploc')->item(0)->childNodes;
        $metrics = array();

        foreach ($nodes as $node) {
            if ($node instanceof DOMElement) {
                $metrics[$this->prefix .  $node->nodeName] = $node->nodeValue;
            }
        }

        return $metrics;
    }
}
