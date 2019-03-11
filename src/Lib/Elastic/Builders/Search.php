<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 05.03.19
 * Time: 23:37
 */

namespace SphereMall\MS\Lib\Elastic\Builders;


use SphereMall\MS\Lib\Elastic\Interfaces\SearchInterface;
use SphereMall\MS\Lib\Elastic\Queries\MultiMatchQuery;
use SphereMall\MS\Lib\Elastic\Queries\MustQuery;

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

    /**
     * @return array
     */
    public function getParams()
    {
        $params = [];

        if ($filter = $this->body->getFilter()) {
            $params = $this->getParamsFromFilter($filter);
        }

        if ($q = $this->body->getQuery()) {
            $params['body']["query"] = array_merge_recursive($q, ($params['body']["query"] ?? []));
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

    /**
     * @param $filter
     *
     * @return array
     */
    private function getParamsFromFilter(FilterBuilder $filter)
    {
        $result = [];
        $query  = [];
        $params = $filter->getParams();

        if ($params['entities']) {
            $result['index'] = $params['entities'];
        }

        if (isset($params['keyword'])) {
            $query[] = new MultiMatchQuery($params['keyword']['value'], $params['keyword']['fields']);
        }

        foreach ($params['params'] ?? [] as $param) {
            /**@var \SphereMall\MS\Lib\Elastic\Interfaces\ElasticParamBuilderInterface $param**/
            $query[] = $param->createFilter();
        }

        if ($query) {
            $result['body']['query'] = (new QueryBuilder())->setMust(new MustQuery($query))->toArray();
        }

        return $result;
    }
}
