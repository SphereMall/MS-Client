<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 18:45
 */

namespace SphereMall\MS\Lib\Elastic\Queries;

use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElementInterface;

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
        return [
            'bool' => [
                $this->queryType => array_map(function (ElasticBodyElementInterface $element) {
                    return $element->toArray();
                }, $this->elements),
            ],
        ];
    }

    /**
     * @param ElasticBodyElementInterface $element
     *
     * @return $this
     */
    private function setElement(ElasticBodyElementInterface $element)
    {
        $this->elements[] = $element;

        return $this;
    }
}
