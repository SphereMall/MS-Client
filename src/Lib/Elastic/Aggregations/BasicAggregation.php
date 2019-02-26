<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 10:54
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;


use SphereMall\MS\Lib\Elastic\Builders\AggregationBuilder;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticAggregationInterface;

class BasicAggregation implements ElasticAggregationInterface
{
    protected $additionalParams = [];
    protected $script           = [];
    protected $subAggregations  = [];

    /**
     * @param array $params
     *
     * @return $this
     */
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

    /**
     * @param AggregationBuilder $aggregation
     *
     * @return ElasticAggregationInterface
     */
    public function subAggregation(AggregationBuilder $aggregation): ElasticAggregationInterface
    {
        $this->subAggregations = $aggregation->toArray();

        return $this;
    }
}
