<?php

abstract class AbstractXmlMetricCollector implements MetricCollectorInterface
{
    protected $file;
    protected $prefix;

    public function __construct($file, $prefix = '')
    {
        $this->file = $file;
        $this->prefix = $prefix;
    }

    /**
     * Get DomNode by Xpath expression
     *
     * @param string $xpathExpression
     *
     * @return DomNodeList
     */
    protected function getNodes($xpathExpression)
    {
        $document = new DOMDocument();
        $document->load($this->file);
        $xpath = new DOMXpath($document);

        return $xpath->query($xpathExpression);
    }
}
