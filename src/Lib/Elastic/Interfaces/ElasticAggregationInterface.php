<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 10:55
 */

namespace SphereMall\MS\Lib\Elastic\Interfaces;

use SphereMall\MS\Lib\Elastic\Builders\AggregationBuilder;

interface ElasticAggregationInterface
{
    /**
     * @param AggregationBuilder $aggregation
     *
     * @return ElasticAggregationInterface
     */
    public function subAggregation(AggregationBuilder $aggregation): ElasticAggregationInterface;

    /**
     * @param array $scriptParams
     *
     * @return mixed
     */
    public function setScript(array $scriptParams): ElasticAggregationInterface;
}
