<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 11:57
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;

use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;
use SphereMall\MS\Lib\Elastic\Queries\BasicBoolQuery;

class FiltersAggregation extends BasicAggregation implements ElasticBodyElement
{
    private $filterName = null;
    private $query      = null;

    public function __construct(string $filterName, BasicBoolQuery $query)
    {
        $this->filterName = $filterName;
        $this->query      = $query;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'filters' => [
                'filters' => [
                    $this->filterName => $this->query->toArray(),
                ],
            ],
        ];
    }
}
