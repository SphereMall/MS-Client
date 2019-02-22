<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 18:01
 */

namespace SphereMall\MS\Lib\Queries\Elastic;


use SphereMall\MS\Lib\Filters\Interfaces\ElasticFilterInterface;

/**
 * Class MatchQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
class MatchQuery extends BasicQuery implements ElasticFilterInterface
{
    private $query    = null;
    private $field    = null;
    private $operator = null;

    /**
     * MatchQuery constructor.
     *
     * @param string $field
     * @param string $query
     * @param string $operator
     */
    public function __construct(string $field, string $query, string $operator = "and")
    {
        $this->query    = $query;
        $this->field    = $field;
        $this->operator = $operator;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'match' => [
                $this->field => array_merge([
                    'query'    => $this->query,
                    'operator' => $this->operator,
                ], $this->additionalParams),
            ],
        ];
    }
}
