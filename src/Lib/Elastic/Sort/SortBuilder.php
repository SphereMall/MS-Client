<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 13:37
 */

namespace SphereMall\MS\Lib\Elastic\Sort;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElementInterface;

/**
 * Class SortBuilder
 *
 * @package SphereMall\MS\Lib\Elastic\Sort
 */
class SortBuilder implements ElasticBodyElementInterface
{
    private $elements = [];

    /**
     * SortBuilder constructor.
     *
     * @param array $sortElements
     */
    public function __construct(array $sortElements)
    {
        foreach ($sortElements as $element) {
            $this->setSort($element);
        }
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'sort' => array_map(function (ElasticBodyElementInterface $sort) {
                return $sort->toArray();
            }, $this->elements),
        ];
    }

    /**
     * @param ElasticBodyElementInterface $element
     *
     * @return $this
     */
    private function setSort(ElasticBodyElementInterface $element)
    {
        $this->elements[] = $element;

        return $this;
    }
}
