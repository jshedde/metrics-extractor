<?php

interface MetricCollectorInterface
{
    /**
     * Return a collection of metric
     *
     * @return array
     */
    public function collect();
}
