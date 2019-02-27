<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 17:38
 */

namespace SphereMall\MS\Lib\Queries\Elastic;


use SphereMall\MS\Lib\Queries\Interfaces\ElasticQueryInterface;

/**
 * Class MultiMatchQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
class MultiMatchQuery extends BasicQuery implements ElasticQueryInterface
{
    private $query    = null;
    private $fields   = [];
    private $operator = null;

    /**
     * MultiMatchQuery constructor.
     *
     * @param string $query
     * @param array  $fields
     * @param string $operator
     */
    public function __construct(string $query, array $fields, string $operator = "and")
    {
        $this->query    = $query;
        $this->fields   = $fields;
        $this->operator = $operator;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'multi_match' => array_merge([
                'query'    => $this->query,
                'fields'   => $this->fields,
                'operator' => $this->operator,
            ], $this->additionalParams),
        ];
    }
}
