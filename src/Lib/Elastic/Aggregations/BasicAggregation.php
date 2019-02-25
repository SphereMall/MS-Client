<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 10:54
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticAggregationInterface;

class BasicAggregation implements ElasticAggregationInterface
{
    protected $additionalParams = [];

    /**
     * @param ElasticAggregationInterface $aggregation
     *
     * @return ElasticAggregationInterface
     */
    public function subAggregation(ElasticAggregationInterface $aggregation): ElasticAggregationInterface
    {
        return $this;
    }

    public function setAdditionalParams(array $params)
    {
        $this->additionalParams = $params;

        return $this;
    }
}
