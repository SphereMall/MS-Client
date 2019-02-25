<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 18:45
 */

namespace SphereMall\MS\Lib\Elastic\Queries;

use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;

/**
 * Class BasicBoolQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
abstract class BasicBoolQuery
{
    protected $elements  = [];
    protected $queryType = null;

    /**
     * BasicBoolQuery constructor.
     *
     * @param array $elements
     */
    public function __construct(array $elements)
    {
        foreach ($elements as $element) {
            $this->setElement($element);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $queries = [];

        foreach ($this->elements as $element) {
            $queries[] = $element->toArray();
        }

        return [
            'bool' => [
                $this->queryType => $queries,
            ],
        ];
    }

    /**
     * @param ElasticBodyElement $element
     *
     * @return $this
     */
    public function setElement(ElasticBodyElement $element)
    {
        $this->elements[] = $element;

        return $this;
    }
}
