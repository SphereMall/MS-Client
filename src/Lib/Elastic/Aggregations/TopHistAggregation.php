<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 11:58
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;
use SphereMall\MS\Lib\Elastic\Sort\SortElement;

class TopHistAggregation extends BasicAggregation implements ElasticBodyElement
{
    private $size   = null;
    private $from   = null;
    private $sort   = [];
    private $source = null;

    public function __construct(int $size = 10, int $from = 0, array $sort = [], $source = [])
    {
        $this->size = $size;
        $this->from = $from;
        if ($sort) {
            foreach ($sort as $sortElement) {
                $this->setSort($sortElement);
            }
        }
        $this->source = $source;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [
            'size' => $this->size,
            'from' => $this->from,
        ];

        if ($this->sort) {
            $result['sort'] = $this->sort;
        }

        if ($this->source) {
            $result['_source'] = $this->source;
        }

        return [
            'top_hits' => $result,
        ];
    }

    private function setSort(SortElement $sortElement)
    {
        $this->sort[] = $sortElement->toArray();

        return $this;
    }
}
