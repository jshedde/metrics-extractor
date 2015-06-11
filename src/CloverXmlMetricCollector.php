<?php

class CloverXmlMetricCollector implements MetricCollectorInterface
{
    protected $file;
    protected $prefix;

    public function __construct($file, $prefix = '')
    {
        $this->file = $file;
        $this->prefix = $prefix;
    }

    public function collect()
    {
        $document = new DOMDocument();
        $document->load($this->file);
        $xpath = new DOMXpath($document);
        $nodes = $xpath->query('/coverage/project/metrics');
        $attributes = $nodes->item(0)->attributes;
        $metrics = array();

        foreach ($attributes as $attribute) {
            $metrics[$this->prefix . $attribute->name] = $attribute->value;
        }

        return $metrics;
    }
}
