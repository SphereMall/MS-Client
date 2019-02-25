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
    protected $script           = [];

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

    /**
     * @param array $scriptParams
     *
     * @return ElasticAggregationInterface
     */
    public function setScript(array $scriptParams): ElasticAggregationInterface
    {
        $this->script = $scriptParams;

        return $this;
    }

}
