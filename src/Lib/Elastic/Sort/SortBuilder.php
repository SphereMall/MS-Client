<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 13:37
 */

namespace SphereMall\MS\Lib\Elastic\Sort;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;

/**
 * Class SortBuilder
 *
 * @package SphereMall\MS\Lib\Elastic\Sort
 */
class SortBuilder implements ElasticBodyElement
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
        $sort = [];

        foreach ($this->elements as $element) {
            /**@var $element \SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement* */
            $sort[] = $element->toArray();
        }

        return [
            'sort' => $sort,
        ];
    }

    /**
     * @param ElasticBodyElement $element
     *
     * @return $this
     */
    private function setSort(ElasticBodyElement $element)
    {
        $this->elements[] = $element;

        return $this;
    }
}
