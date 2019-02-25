<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 10:55
 */

namespace SphereMall\MS\Lib\Elastic\Interfaces;


interface ElasticAggregationInterface
{
    /**
     * @param ElasticAggregationInterface $aggregation
     *
     * @return ElasticAggregationInterface
     */
    public function subAggregation(ElasticAggregationInterface $aggregation): ElasticAggregationInterface;
}
