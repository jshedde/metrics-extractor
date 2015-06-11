<?php

class CheckstyleXmlMetricCollector extends AbstractXmlMetricCollector implements MetricCollectorInterface
{
    public function collect()
    {
        $metrics = array();
        foreach (array('error', 'warning') as $severity) {
            $nodes = $this->getNodes(sprintf('//error[@severity="%s"]', $severity));

            $tmp = array();
            foreach ($nodes as $node) {
                $source = $node->attributes->getNamedItem('source')->value;
                if (false === array_key_exists($source, $tmp)) {
                    $tmp[$source] = 0;
                }
                $tmp[$source]++;
            }

            $prefix = $this->prefix . $severity . '.';
            foreach ($tmp as $metric => $cnt) {
                $metrics[$prefix . $metric] = $cnt;
            }
        }
        return $metrics;
    }
}
