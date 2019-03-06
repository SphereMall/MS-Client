<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 26.02.19
 * Time: 9:17
 */

namespace SphereMall\MS\Lib\Elastic\Builders;

use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElementInterface;

/**
 * Class AggregationBuilder
 *
 * @package SphereMall\MS\Lib\Elastic\Aggregations
 */
class AggregationBuilder implements ElasticBodyElementInterface
{
    private $aggregationName = null;
    private $aggregation     = null;

    /**
     * AggregationBuilder constructor.
     *
     * @param string             $name
     * @param ElasticBodyElementInterface $aggregation
     */
    public function __construct(string $name, ElasticBodyElementInterface $aggregation)
    {
        $this->aggregationName = $name;
        $this->aggregation     = $aggregation;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->aggregationName => $this->aggregation->toArray(),
        ];
    }
}
