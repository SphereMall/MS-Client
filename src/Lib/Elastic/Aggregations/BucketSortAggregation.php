<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 11:58
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElementInterface;
use SphereMall\MS\Lib\Elastic\Sort\SortElement;

/**
 * Class BucketSortAggregation
 *
 * @package SphereMall\MS\Lib\Elastic\Aggregations
 */
class BucketSortAggregation extends BasicAggregation implements ElasticBodyElementInterface
{
    private $size = 0;
    private $from = 0;
    private $sort = [];

    /**
     * BucketSortAggregation constructor.
     *
     * @param       $size
     * @param int   $from
     * @param array $sort
     */
    public function __construct($size, $from = 0, array $sort = [])
    {
        $this->size = $size;
        $this->from = $from;

        if ($sort) {
            foreach ($sort as $sortItem) {
                $this->setSortItem($sortItem);
            }
        }
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $response = [
            'from' => $this->from,
            'size' => $this->size,
        ];

        if ($this->sort) {
            $response['sort'] = $this->sort;
        }

        return [
            'bucket_sort' => $response
        ];
    }

    /**
     * @param SortElement $sortElement
     *
     * @return $this
     */
    private function setSortItem(SortElement $sortElement)
    {
        $this->sort[] = $sortElement->toArray();

        return $this;
    }
}
