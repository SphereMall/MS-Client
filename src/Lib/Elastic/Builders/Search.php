<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 05.03.19
 * Time: 23:37
 */

namespace SphereMall\MS\Lib\Elastic\Builders;


use SphereMall\MS\Lib\Elastic\Interfaces\SearchInterface;

/**
 * Class Search
 *
 * @package SphereMall\MS\Lib\Elastic\Builders
 */
class Search implements SearchInterface
{
    private $body = null;

    /**
     * Search constructor.
     *
     * @param BodyBuilder $builder
     */
    public function __construct(BodyBuilder $builder)
    {
        $this->body = $builder;
    }

    public function getParams()
    {
        $params = [];
        if ($q = $this->body->getQuery()) {
            $params['body']["query"] = $q;
        }

        if ($size = $this->body->getLimit()) {
            $params['body']['size'] = $size;
        }

        if ($from = $this->body->getOffset()) {
            $params['body']['from'] = $from;
        }

        if ($source = $this->body->getSource()) {
            $params['body']['_source'] = $source;
        }

        if ($indexes = $this->body->getIndexes()) {
            $params['index'] = $indexes;
        }

        if ($aggregations = $this->body->getAggregations()) {
            $params['body']['aggs'] = $aggregations;
        }

        if ($sort = $this->body->getSort()) {
            $params['body']['sort'] = $sort;
        }

        return $params;
    }
}
